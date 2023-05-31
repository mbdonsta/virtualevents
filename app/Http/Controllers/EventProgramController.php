<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventProgram;
use App\Models\EventRoom;
use App\Models\EventUserActivity;
use App\Models\User;
use App\Services\EventProgramService;
use App\Services\EventService;
use App\Services\EventUserActivityService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventProgramController extends Controller
{
    public function view(string $slug, EventProgramService $eventProgramService): View
    {
        $event = (new EventService)->findBySlug($slug);

        if (!$event || auth()->user()->cannot('view', [EventProgram::class, $event])) {
            abort(404);
        }

        if (auth()->user()->isParticipant()) {
            $this->logProgramVisited(auth()->user(), $event);
        }

        $eventDays = $eventProgramService->getDaysByEvent($event->id);

        return view('frontend.events.program.view', compact('event', 'eventDays'));
    }

    private function logProgramVisited(User $user, Event $event)
    {
        $eventUser = $user->attachedEvent()->where('event_id', $event->id)->first();
        $visited = EventUserActivity::where('activity', EventUserActivity::VISITED_PROGRAM)
            ->where('event_user_id', $eventUser->id)
            ->first();

        if (!$visited) {
            $attributes = [
                'event_id' => $event->id,
                'event_user_id' => $eventUser->id,
                'activity' => EventUserActivity::VISITED_PROGRAM,
                'activity_value' => EventUserActivity::DEFAULT_VALUE
            ];
            EventUserActivityService::create($attributes);
        }
    }
}
