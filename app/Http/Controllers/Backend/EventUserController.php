<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventUserStoreRequest;
use App\Models\Event;
use App\Models\EventUser;
use App\Models\Role;
use App\Services\EventUserService;
use App\Services\PermissionService;
use App\Services\ProfileService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventUserController extends Controller
{
    public const PER_PAGE = 50;

    public function index(Request $request, Event $event): View
    {
        $this->authorize('create', [EventUser::class, $event]);

        $eventUsers = (new EventUserService)->getAllPaginate($event, $request->keyword);
        $pageTitle = __('Event Participants');

        return view('backend.users.index', compact('eventUsers', 'event', 'pageTitle'));
    }

    public function add(Event $event): View|RedirectResponse
    {
        $this->authorize('create', [EventUser::class, $event]);
        if (count($event->eventUsers) >= $event->plan->maxParticipants()) {
            session()->flash('error', __('This event plan is limited to :num participants', ['num' => $event->plan->maxParticipants()]));

            return redirect()->route('backend.users.index', ['event' => $event->id]);
        }

        $pageTitle = __('Create Event Participant');

        return view('backend.users.add', compact('event', 'pageTitle'));
    }

    public function store(EventUserStoreRequest $request, Event $event): RedirectResponse
    {
        $this->authorize('create', [EventUser::class, $event]);
        if (count($event->eventUsers) >= $event->plan->maxParticipants()) {
            session()->flash('error', __('This event plan is limited to :num participants', ['num' => $event->plan->maxParticipants()]));

            return redirect()->route('backend.users.index', ['event' => $event->id]);
        }

        $attributes = $request->validated();
        $attributes['event_id'] = $event->id;
        $user = (new UserService)->findByEmail($attributes['email']);

        if (!$user) {
            $attributes['role_id'] = Role::PARTICIPANT_ROLE_ID;
            $user = (new UserService)->create($attributes);
        }

        $attributes['user_id'] = $user->id;
        (new EventUserService)->create($attributes);
        session()->flash('success', __('Event user was attached successfully.'));

        return redirect()->route('backend.users.index', ['event' => $event->id]);
    }

    public function edit(EventUser $eventUser): View
    {
        $this->authorize('edit', $eventUser);
        $event = $eventUser->event;
        $pageTitle = __('Edit Event Participant');

        return view('backend.users.edit', compact('event', 'eventUser', 'pageTitle'));
    }

    public function update(EventUserStoreRequest $request, EventUser $eventUser): RedirectResponse
    {
        $this->authorize('edit', $eventUser);

        $attributes = $request->validated();
        (new EventUserService)->update($eventUser, $attributes);
        session()->flash('success', __('Event user was updated successfully.'));

        return redirect()->route('backend.users.index', ['event' => $eventUser->event_id]);
    }

    public function import(Event $event): View
    {
        $this->authorize('create', [EventUser::class, $event]);
        $pageTitle = __('Import Participants');

        return view('backend.users.import', compact('event', 'pageTitle'));
    }

    public function delete(EventUser $eventUser): RedirectResponse
    {
        $this->authorize('delete', $eventUser);

        $eventUser->delete();
        session()->flash('success', __('Event user was detached successfully.'));

        return redirect()->route('backend.users.index', ['event' => $eventUser->event_id]);
    }

    public function getList(Request $request, Event $event): JsonResponse
    {
        $this->authorize('create', [EventUser::class, $event]);
        $result = $this->prepareForAjaxResponse((new EventUserService)->getByKeyword($event->id, $request->keyword));

        return response()->json($result);
    }

    private function prepareForAjaxResponse(array $eventUsers): array
    {
        $response = [];

        foreach ($eventUsers as $eventUser) {
            $text = $eventUser['user']['profile']['firstname'];
            $text .= ' ' . $eventUser['user']['profile']['lastname'];
            $text .= ' (' . $eventUser['user']['email'] . ')';

            $response[] = [
                'id' => $eventUser['user_id'],
                'text' => $text
            ];
        }

        return $response;
    }
}
