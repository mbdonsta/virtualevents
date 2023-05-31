<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\EventPoster;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPosterPolicy
{
    public function view(User $user, EventPoster $eventPoster): bool
    {
        return true;
    }

    public function create(User $user, Event $event): bool
    {
        return $user->allowed('manage_events') || $user->id === $event->user_id;
    }

    public function edit(User $user, EventPoster $eventPoster): bool
    {
        return $user->allowed('manage_events') || $user->id === $eventPoster->event->user_id;
    }

    public function update(User $user, EventPoster $eventPoster): bool
    {
        return $user->allowed('manage_events') || $user->id === $eventPoster->event->user_id;
    }

    public function delete(User $user, EventPoster $eventPoster): bool
    {
        return $user->allowed('manage_events') || $user->id === $eventPoster->event->user_id;
    }
}
