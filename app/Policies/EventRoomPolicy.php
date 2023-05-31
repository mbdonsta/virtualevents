<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\EventRoom;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventRoomPolicy
{
    public function view(User $user, EventRoom $eventRoom): bool
    {
        if ($user->allowed('manage_events') || $user->id === $eventRoom->event->user_id) {
            return true;
        }

        if ($eventRoom->isEnabled() && $eventRoom->event->isEnabled()) {
            return $eventRoom->allowedToAll() || $eventRoom->hasUser($user->id);
        }

        return false;

    }

    public function create(User $user, Event $event): bool
    {
        return $user->allowed('manage_events') || $user->id === $event->user_id;
    }

    public function edit(User $user, EventRoom $eventRoom): bool
    {
        return $user->allowed('manage_events') || $user->id === $eventRoom->event->user_id;
    }

    public function update(User $user, EventRoom $eventRoom): bool
    {
        return $user->allowed('manage_events') || $user->id === $eventRoom->event->user_id;
    }

    public function delete(User $user, EventRoom $eventRoom): bool
    {
        return $user->allowed('manage_events') || $user->id === $eventRoom->event->user_id;
    }
}
