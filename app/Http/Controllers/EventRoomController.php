<?php

namespace App\Http\Controllers;

use App\Models\EventRoom;
use App\Models\EventRoomBanner;
use App\Services\EventService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventRoomController extends Controller
{
    public function view(string $slug, EventRoom $eventRoom): View
    {
        $event = (new EventService)->findBySlug($slug);

        if (!$event || auth()->user()->cannot('view', [$eventRoom, $event])) {
            abort(404);
        }

        $currentDateTime = Carbon::now()->format('Y-m-d H:i:s');
        $banners = EventRoomBanner::with(['bannerImage', 'downloadFile'])->where('event_room_id', $eventRoom->id)->oldest('menu_order')->get();

        return view('frontend.events.rooms.view', compact('event', 'eventRoom', 'currentDateTime', 'banners'));
    }
}
