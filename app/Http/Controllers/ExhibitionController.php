<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventUserActivity;
use App\Models\User;
use App\Services\EventService;
use App\Services\EventUserActivityService;
use App\Services\ExhibitionGroupService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExhibitionController extends Controller
{
    public function index(string $slug, ExhibitionGroupService $exhibitionGroupService): View
    {
        $event = (new EventService)->findBySlug($slug);

        if (!$event || auth()->user()->cannot('view', $event)) {
            abort(404);
        }

        $this->logExhibitionVisited(auth()->user(), $event);
        $exhibitionGroups = $exhibitionGroupService->getByEvent($event->id);

        return view('frontend.events.exhibition.view', compact('event', 'exhibitionGroups'));
    }

    private function logExhibitionVisited(User $user, Event $event)
    {
        $eventUser = $user->attachedEvent()->where('event_id', $event->id)->first();
        $visited = EventUserActivity::where('activity', EventUserActivity::VISITED_EXHIBITION)
            ->where('event_user_id', $eventUser->id)
            ->first();
        if (!$visited) {
            $attributes = [
                'event_id' => $event->id,
                'event_user_id' => $eventUser->id,
                'activity' => EventUserActivity::VISITED_EXHIBITION,
                'activity_value' => EventUserActivity::DEFAULT_VALUE
            ];
            EventUserActivityService::create($attributes);
        }
    }
}
