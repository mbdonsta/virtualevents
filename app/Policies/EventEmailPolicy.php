<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\EventEmail;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventEmailPolicy
{
    public function edit(User $user, Event $event)
    {
        return $user->allowed('manage_events') || $user->id === $event->user_id;
    }

    public function update(User $user, EventEmail $eventEmail)
    {
        return $user->allowed('manage_events') || $user->id === $eventEmail->event->user_id;
    }

    public function send(User $user, EventEmail $eventEmail)
    {
        return $user->allowed('manage_events') || $user->id === $eventEmail->event->user_id;
    }
}
