<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class EventService
{
    private $builder;

    public function __construct()
    {
        $this->builder = Event::with(['eventRooms', 'plan']);
    }

    public function create(array $data): Event
    {
        return Event::create($data);
    }

    public function update(Event $event, array $data): void
    {
        $event->update($data);
    }

    public function filter(Request $request): EventService
    {
        if ($request->keyword) {
            $this->builder = $this->builder->where(function ($q) use ($request) {
                $q->orWhere('title', 'like', '%' . $request->keyword . '%')
                    ->orWhere('subject', 'like', '%' . $request->keyword . '%')
                    ->orWhere('description', 'like', '%' . $request->keyword . '%');
            });
        }

        return $this;
    }

    public function ownedBy(int $userId): EventService
    {
        $this->builder = $this->builder->where('user_id', $userId);

        return $this;
    }

    public function getCollection(array $fields = ['*']): Collection
    {
        return $this->builder->get($fields);
    }

    public function paginate(int $itemsPerPage, array $fields = ['*']): LengthAwarePaginator
    {
        return $this->builder->paginate($itemsPerPage, $fields);
    }

    public function findBySlug(string $slug): ?Event
    {
        return Event::with(['eventRooms' => function ($q) {
            $q->orderBy('menu_order', 'asc');
        }])
            ->where('slug', $slug)->first();
    }

    public function orderBy(string $column, string $direction): EventService
    {
        $this->builder = $this->builder->orderBy($column, $direction);

        return $this;
    }

    public function getEventsForParticipant(int $participantId): Collection
    {
        return Event::enabled()->whereHas('eventUsers', function ($q) use ($participantId) {
            $q->where('user_id', $participantId);
        })->orderBy('begin_datetime', 'desc')->get();
    }
}
