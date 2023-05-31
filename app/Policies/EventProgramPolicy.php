<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\EventProgram;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventProgramPolicy
{
    public function view(User $user, Event $event): bool
    {
        return $user->allowed('manage_events')
            || $user->id === $event->user_id
            || (($user->isAttachedTo($event->id) || $event->isPublic()) && $event->isEnabled());
    }

    public function create(User $user, Event $event)
    {
        return $user->allowed('manage_events') || $user->id === $event->user_id;
    }

    public function edit(User $user, EventProgram $eventProgram)
    {
        return $user->allowed('manage_events') || $user->id === $eventProgram->event->user_id;
    }

    public function update(User $user, EventProgram $eventProgram)
    {
        return $user->allowed('manage_events') || $user->id === $eventProgram->event->user_id;
    }

    public function delete(User $user, EventProgram $eventProgram)
    {
        return $user->allowed('manage_events') || $user->id === $eventProgram->event->user_id;
    }
}
