<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\ExhibitionStand;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExhibitionStandPolicy
{
    public function create(User $user, Event $event): bool
    {
        return $user->allowed('manage_events') || $user->id === $event->user_id;
    }

    public function edit(User $user, ExhibitionStand $exhibitionStand): bool
    {
        return $user->allowed('manage_events') || $user->id === $exhibitionStand->event->user_id;
    }

    public function update(User $user, ExhibitionStand $exhibitionStand): bool
    {
        return $user->allowed('manage_events') || $user->id === $exhibitionStand->event->user_id;
    }

    public function delete(User $user, ExhibitionStand $exhibitionStand): bool
    {
        return $user->allowed('manage_events') || $user->id === $exhibitionStand->event->user_id;
    }
}
