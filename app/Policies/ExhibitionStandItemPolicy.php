<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\ExhibitionStand;
use App\Models\ExhibitionStandItem;
use App\Models\User;

class ExhibitionStandItemPolicy
{
    public function create(User $user, Event $event): bool
    {
        return $user->allowed('manage_events') || $user->id === $event->user_id;
    }

    public function edit(User $user, ExhibitionStandItem $exhibitionStandItem): bool
    {
        return $user->allowed('manage_events') || $user->id === $exhibitionStandItem->exhibitionStand->event->user_id;
    }

    public function update(User $user, ExhibitionStandItem $exhibitionStandItem): bool
    {
        return $user->allowed('manage_events') || $user->id === $exhibitionStandItem->exhibitionStand->event->user_id;
    }

    public function delete(User $user, ExhibitionStandItem $exhibitionStandItem): bool
    {
        return $user->allowed('manage_events') || $user->id === $exhibitionStandItem->exhibitionStand->event->user_id;
    }
}
