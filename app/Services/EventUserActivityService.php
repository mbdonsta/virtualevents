<?php

namespace App\Services;


use App\Models\EventUserActivity;

class EventUserActivityService
{
    public static function create(array $attributes): void
    {
        EventUserActivity::create($attributes);
    }

    public static function totalVisits(int $eventId): int
    {
        return EventUserActivity::where('event_id', $eventId)
            ->groupBy('event_user_id')
            ->get(['event_user_id'])
            ->count();
    }

    public static function getTotalByEventActivity(int $eventId, int $activity): int
    {
        return EventUserActivity::where('activity', $activity)->where('event_id', $eventId)->count();
    }

    public static function getPosterVote(int $eventUserId): ?EventUserActivity
    {
        return EventUserActivity::where('event_user_id', $eventUserId)
            ->where('activity', EventUserActivity::POSTER_VOTE)
            ->first();
    }
}
