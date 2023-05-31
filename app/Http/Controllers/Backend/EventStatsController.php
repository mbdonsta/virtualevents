<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventUserActivity;
use App\Services\EventUserActivityService;
use App\Services\EventUserService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventStatsController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function eventStats(Event $event): View
    {
        $this->authorize('edit', $event);

        $totalVisitors = EventUserActivityService::totalVisits($event->id);
        $totalInvited = count(EventUserService::getInvitedUsersByEvent($event->id));
        $totalProgramVisits = EventUserActivityService::getTotalByEventActivity($event->id, EventUserActivity::VISITED_PROGRAM);
        $totalExhibitionVisits = EventUserActivityService::getTotalByEventActivity($event->id, EventUserActivity::VISITED_EXHIBITION);
        $totalPostersVisits = EventUserActivityService::getTotalByEventActivity($event->id, EventUserActivity::VISITED_POSTERS);
        $pageTitle = __('Event Statistics');
        $compact = compact(
            'event',
            'totalInvited',
            'totalProgramVisits',
            'totalVisitors',
            'totalExhibitionVisits',
            'totalPostersVisits',
            'pageTitle'
        );

        return view('backend.stats.event', $compact);
    }
}
