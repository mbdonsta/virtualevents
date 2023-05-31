<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventUserActivity;
use App\Models\ExhibitionStand;
use App\Models\User;
use App\Services\EventService;
use App\Services\EventUserActivityService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExhibitionStandController extends Controller
{
    public function view(string $slug, ExhibitionStand $exhibitionStand): View
    {
        $event = (new EventService)->findBySlug($slug);

        if (!$event || auth()->user()->cannot('view', $event) || $event->id !== $exhibitionStand->event_id) {
            abort(404);
        }

        $this->logStandVisited(auth()->user(), $event, $exhibitionStand);

        return view('frontend.events.exhibition_stand.view', compact('exhibitionStand', 'event'));
    }

    private function logStandVisited(User $user, Event $event, ExhibitionStand $exhibitionStand)
    {
        $eventUser = $user->attachedEvent()->where('event_id', $event->id)->first();
        $visited = EventUserActivity::where('activity', EventUserActivity::VISITED_EXHIBITION_STAND)
            ->where('event_user_id', $eventUser->id)
            ->where('model_id', $exhibitionStand->id)
            ->first();
        if (!$visited) {
            $attributes = [
                'event_id' => $event->id,
                'event_user_id' => $eventUser->id,
                'activity' => EventUserActivity::VISITED_EXHIBITION_STAND,
                'model_id' => $exhibitionStand->id,
                'activity_value' => EventUserActivity::DEFAULT_VALUE
            ];
            EventUserActivityService::create($attributes);
        }
    }
}
