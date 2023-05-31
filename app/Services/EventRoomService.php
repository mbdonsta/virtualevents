<?php

namespace App\Services;

use App\Models\EventRoom;
use App\Models\EventRoomUser;
use Illuminate\Pagination\LengthAwarePaginator;

class EventRoomService
{
    private const PER_PAGE = 15;

    public function attachRoomUsers(EventRoom $eventRoom, array $userIds): void
    {
        $eventRoom->eventRoomUsers()->delete();

        foreach ($userIds as $userId) {
            EventRoomUser::create([
                'event_room_id' => $eventRoom->id,
                'user_id' => $userId
            ]);
        }
    }

    public function create(array $data): EventRoom
    {
        return EventRoom::create($data);
    }

    public function updateMenuOrders(int $eventId): void
    {
        $eventRooms = EventRoom::where('event_id', $eventId)->orderBy('menu_order', 'asc')->get();

        foreach ($eventRooms as $index => $eventRoom) {
            $eventRoom->update([
                'menu_order' => $index
            ]);
        }
    }

    public function update(EventRoom $eventRoom, array $data): void
    {
        $eventRoom->update($data);
    }

    public function getRoomsByEvent(int $eventId): LengthAwarePaginator
    {
        return EventRoom::with('event')
            ->where('event_id', $eventId)
            ->orderBy('menu_order', 'asc')
            ->paginate(self::PER_PAGE);
    }
}
