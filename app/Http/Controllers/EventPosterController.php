<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventPoster;
use App\Models\EventUserActivity;
use App\Models\User;
use App\Services\EventService;
use App\Services\EventUserActivityService;
use Illuminate\Http\RedirectResponse;

class EventPosterController extends Controller
{
    public function index(string $slug)
    {
        $event = (new EventService)->findBySlug($slug);

        if (!$event || auth()->user()->cannot('view', $event)) {
            abort(404);
        }

        $eventUser = auth()->user()->attachedEvent()->where('event_id', $event->id)->first();
        $vote = EventUserActivityService::getPosterVote(0);
        $posters = EventPoster::with('posterImage')->where('event_id', $event->id)->get();

        return view('frontend.events.posters.index', compact('event', 'posters', 'vote'));
    }

    public function vote(EventPoster $eventPoster): RedirectResponse
    {
        if (auth()->user()->cannot('view', $eventPoster->event)) {
            abort(404);
        }

        $eventUser = auth()->user()->attachedEvent()->where('event_id', $eventPoster->event_id)->first();
        $voted = EventUserActivity::where('activity', EventUserActivity::POSTER_VOTE)
            ->where('event_user_id', $eventUser->id)
            ->first();
        if (!$voted) {
            $attributes = [
                'event_id' => $eventPoster->event_id,
                'event_user_id' => $eventUser->id,
                'model_id' => $eventPoster->id,
                'activity' => EventUserActivity::POSTER_VOTE,
                'activity_value' => 1
            ];
            EventUserActivityService::create($attributes);
        }

        return back();
    }

    private function logPostersVisited(User $user, Event $event)
    {
        $eventUser = $user->attachedEvent()->where('event_id', $event->id)->first();
        $visited = EventUserActivity::where('activity', EventUserActivity::VISITED_POSTERS)
            ->where('event_user_id', $eventUser->id)
            ->first();
        if (!$visited) {
            $attributes = [
                'event_id' => $event->id,
                'event_user_id' => $eventUser->id,
                'activity' => EventUserActivity::VISITED_POSTERS,
                'activity_value' => EventUserActivity::DEFAULT_VALUE
            ];
            EventUserActivityService::create($attributes);
        }
    }
}
