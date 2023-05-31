<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;

class EventPolicy
{
    public function view(User $user, Event $event): bool
    {
        return $user->allowed('manage_events')
            || $user->id === $event->user_id
            || (($user->isAttachedTo($event->id) || $event->isPublic()) && $event->isEnabled());
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function seeList(User $user): bool
    {
        return $user->allowed('manage_events') || $user->allowed('manage_owned_events');
    }

    public function edit(User $user, Event $event): bool
    {
        return $user->allowed('manage_events') || $user->id === $event->user_id;
    }

    public function update(User $user, Event $event): bool
    {
        return $user->allowed('manage_events') || $user->id === $event->user_id;
    }

    public function delete(User $user, Event $event): bool
    {
        return $user->isAdmin();
    }
}
