<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\ExhibitionGroup;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExhibitionGroupPolicy
{
    public function create(User $user, Event $event): bool
    {
        return $user->allowed('manage_events') || $user->id === $event->user_id;
    }

    public function edit(User $user, ExhibitionGroup $exhibitionGroup): bool
    {
        return $user->allowed('manage_events') || $user->id === $exhibitionGroup->event->user_id;
    }

    public function update(User $user, ExhibitionGroup $exhibitionGroup): bool
    {
        return $user->allowed('manage_events') || $user->id === $exhibitionGroup->event->user_id;
    }

    public function delete(User $user, ExhibitionGroup $exhibitionGroup): bool
    {
        return $user->allowed('manage_events') || $user->id === $exhibitionGroup->event->user_id;
    }
}
