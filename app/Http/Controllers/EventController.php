<?php

namespace App\Http\Controllers;

use App\Services\EventService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EventController extends Controller
{
    public function watch(string $slug): RedirectResponse
    {
        $event = (new EventService)->findBySlug($slug);

        if (!$event || auth()->user()->cannot('view', $event)) {
            abort(404);
        }

        return redirect()->route('frontend.events.program.view', ['slug' => $event->slug]);
    }

    public function eventInvitations(): View
    {
        $events = (new EventService)->getEventsForParticipant(auth()->user()->id);

        return view('frontend.events.event_invitations', compact('events'));
    }
}
