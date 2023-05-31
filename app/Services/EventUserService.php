<?php

namespace App\Services;

use App\Models\Event;
use App\Models\EventUser;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class EventUserService
{
    private const PER_PAGE = 50;

    public static function getInvitedUsersByEvent(): Collection
    {
        return EventUser::invited()->get();
    }

    public function create(array $data): void
    {
        $data['access_number'] = implode(
            '-',
            [rand(100, 9999999), microtime(true) * 10000, rand(100, 9999999)]
        );
        EventUser::create($data);
    }

    public function update(EventUser $eventUser, array $data): void
    {
        $eventUser->update($data);
    }

    public function createMultiple(array $data): void
    {
        EventUser::insert($data);
    }

    public function getAllPaginate(Event $event, ?string $keyword): LengthAwarePaginator
    {
        $eventUsers = EventUser::with(['user.profile', 'event'])
            ->where('event_id', $event->id);

        if ($keyword) {
            $eventUsers = $eventUsers->whereHas('user', function ($q) use ($keyword) {
                $q->whereHas('profile', function ($subq) use ($keyword) {
                    $subq->where('firstname', 'like', '%' . $keyword . '%')
                        ->orWhere('lastname', 'like', '%' . $keyword . '%');
                })->orWhere('email', 'like', '%' . $keyword . '%');
            });
        }

        return $eventUsers->paginate(self::PER_PAGE);

    }

    public function getByEventId(int $eventId): Collection
    {
        return EventUser::where('event_id', $eventId)->get();
    }

    public function getByKeyword(int $eventId, ?string $keyword): array
    {
        return EventUser::with('user.profile')->whereHas('user', function ($q) use ($keyword) {
            $q->whereHas('profile', function ($subq) use ($keyword) {
                $subq->where('firstname', 'like', '%' . $keyword . '%')
                    ->orWhere('lastname', 'like', '%' . $keyword . '%');
            })
                ->orWhere('email', 'like', '%' . $keyword . '%');;
        })
            ->where('event_id', $eventId)
            ->limit(8)
            ->get()
            ->toArray();
    }
}
