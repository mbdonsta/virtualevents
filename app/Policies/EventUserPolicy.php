<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\EventUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventUserPolicy
{
    public function create(User $user, Event $event): bool
    {
        return $user->allowed('manage_events') || $user->id === $event->user_id;
    }

    public function edit(User $user, EventUser $eventUser): bool
    {
        return $user->allowed('manage_events') || $user->id === $eventUser->event->user_id;
    }

    public function delete(User $user, EventUser $eventUser): bool
    {
        return $user->allowed('manage_events') || $user->id === $eventUser->event->user_id;
    }
}
