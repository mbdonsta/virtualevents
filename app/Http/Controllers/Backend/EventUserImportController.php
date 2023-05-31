<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventUserImportFileRequest;
use App\Imports\EventUserImport;
use App\Models\Event;
use App\Models\EventUser;
use App\Models\Role;
use App\Services\EventUserService;
use App\Services\PermissionService;
use App\Services\ProfileService;
use App\Services\UserService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Excel;
use Illuminate\Support\Str;

class EventUserImportController extends Controller
{
    private const FIRSTNAME_INDEX = 0;
    private const LASTNAME_INDEX = 1;
    private const EMAIL_INDEX = 2;
    private const TAKE = 250;

    /**
     * @throws AuthorizationException
     */
    public function checkFile(EventUserImportFileRequest $request, Event $event): JsonResponse
    {
        $this->authorize('create', [EventUser::class, $event]);

        try {
            $extractedUsers = $this->prepareImportData($request->file('import_file'));
        } catch (\Exception $exception) {
            $response = [
                'errors' => [
                    'import_file' => [
                        __('Invalid CSV file. Please check if your CSV file has 3 columns and columns is separated with comma. Refresh this page and try again.')
                    ]
                ]
            ];

            return response()->json($response, 422);
        }

        $maxImport = $event->plan->maxParticipants() - count($event->eventUsers);

        if (count($extractedUsers) > $maxImport) {
            return response()->json(
                [
                    'errors' => [
                        'import_file' => [
                            __(
                                'Participant import failed. You will exceed your event plan participants. Trying to import :num, available to import :count',
                                ['num' => count($extractedUsers), 'count' => $maxImport]
                            )
                        ]
                    ]
                ],
                422
            );
        }

        return response()->json([
            'rows_found' => count($extractedUsers)
        ]);
    }

    private function prepareImportData(UploadedFile $file): array
    {
        $extractedUsers = [];

        if (($open = fopen($file, "r")) !== FALSE) {
            while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
                $extractedUsers[] = [
                    'firstname' => isset($data[self::FIRSTNAME_INDEX]) ? preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $data[self::FIRSTNAME_INDEX]) : '',
                    'lastname' => isset($data[self::LASTNAME_INDEX]) ? preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $data[self::LASTNAME_INDEX]) : '',
                    'email' => isset($data[self::EMAIL_INDEX]) ? preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $data[self::EMAIL_INDEX]) : ''
                ];
            }

            fclose($open);
        }

        return $extractedUsers;
    }

    public function import(Request $request, Event $event): JsonResponse
    {
        $this->authorize('create', [EventUser::class, $event]);

        try {
            $extractedUsers = $this->prepareImportData($request->file('import_file'));
        } catch (\Exception $exception) {
            $response = [
                'errors' => [
                    'import_file' => [
                        __('Invalid CSV file. Please check if your CSV file has 3 columns and columns is separated with comma. Refresh this page and try again.')
                    ]
                ]
            ];

            return response()->json($response, 422);
        }

        $collection = collect(array_slice($extractedUsers, $request->skip, self::TAKE));
        $existingUsers = (new UserService)->getByEmails($collection->pluck('email')->toArray())->keyBy('email')->toArray();
        $existingEventUsers = (new EventUserService)->getByEventId($event->id)->pluck('user_id')->toArray();
        $usersForInsert = [];
        $alreadyExist = 0;
        $insertedToEvent = 0;
        $duplicatesInFile = 0;
        $invalidEmails = [];
        $parsedEmails = [];

        foreach ($collection as $extractedUser) {
            if (filter_var($extractedUser['email'], FILTER_VALIDATE_EMAIL) === false) {
                $invalidEmails[] = $extractedUser;

                continue;
            }

            if (!isset($existingUsers[$extractedUser['email']])) {
                $extractedUser['role_id'] = Role::PARTICIPANT_ROLE_ID;
                $user = (new UserService)->create($extractedUser);
                $userId = $user->id;
            } else {
                $userId = $existingUsers[$extractedUser['email']]['id'];
                $alreadyExist++;
            }

            $usersForInsert[] = [
                'id' => $userId,
                'firstname' => $extractedUser['firstname'],
                'lastname' => $extractedUser['lastname']
            ];
        }

        $usersForInsertCollection = collect($usersForInsert);
        $prepareEventUserData = [];

        foreach ($usersForInsertCollection as $userForInsert) {
            if (!in_array($userForInsert['id'], $existingEventUsers)) {
                $prepareEventUserData[] = [
                    'event_id' => $event->id,
                    'user_id' => $userForInsert['id'],
                    'firstname' => $userForInsert['firstname'],
                    'lastname' => $userForInsert['lastname'],
                    'access_number' => implode(
                        '-',
                        [
                            rand(100, 9999999),
                            microtime(true) * 10000,
                            rand(100, 9999999)
                        ]
                    )
                ];
                $insertedToEvent++;
            }
        }

        (new EventUserService)->createMultiple($prepareEventUserData);

        return response()->json([
            'already_exist' => $alreadyExist - $duplicatesInFile,
            'inserted' => $insertedToEvent,
            'invalid_emails' => $invalidEmails,
            'duplicates_in_file' => $duplicatesInFile,
            'parsed' => $parsedEmails
        ]);
    }
}
