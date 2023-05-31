<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventRoomStoreRequest;
use App\Http\Requests\UploadMediaFileRequest;
use App\Models\Event;
use App\Models\EventRoom;
use App\Models\VideoSource;
use App\Services\EventRoomService;
use App\Services\FileUploadHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventRoomController extends Controller
{
    public function index(Event $event): View
    {
        $this->authorize('create', [EventRoom::class, $event]);

        $eventRooms = (new EventRoomService)->getRoomsByEvent($event->id);
        $pageTitle = __('Event Rooms');

        return view('backend.rooms.index', compact('eventRooms', 'event', 'pageTitle'));
    }

    public function add(Event $event): View|RedirectResponse
    {
        $this->authorize('create', [EventRoom::class, $event]);
        if (count($event->eventRooms) >= $event->plan->maxRooms()) {
            session()->flash('error', __('This event plan is limited to :num room', ['num' => $event->plan->maxRooms()]));

            return redirect()->route('backend.rooms.index', ['event' => $event->id]);
        }

        $videoSources = VideoSource::all();
        $pageTitle = __('Create Event Room');

        return view('backend.rooms.add', compact('event', 'videoSources', 'pageTitle'));
    }

    public function store(EventRoomStoreRequest $request, Event $event): RedirectResponse
    {
        $this->authorize('create', [EventRoom::class, $event]);

        $attributes = $request->validated();
        $attributes['event_id'] = $event->id;
        $lastEventRoom = EventRoom::where('event_id', $event->id)->orderBy('menu_order', 'desc')->first();
        $attributes['menu_order'] = $lastEventRoom ? $lastEventRoom->menu_order + 1 : 0;

        if (!isset($attributes['room_participants'])) {
            $attributes['room_participants'] = [];
        }

        $eventRoom = (new EventRoomService)->create($attributes);

        if (!$attributes['allow_all']) {
            (new EventRoomService)->attachRoomUsers($eventRoom, $attributes['room_participants']);
        }

        session()->flash('success', __('Event room was created successfully.'));

        return redirect()->route('backend.rooms.edit', ['eventRoom' => $eventRoom->id]);
    }

    public function edit(EventRoom $eventRoom): View
    {
        $this->authorize('edit', $eventRoom);

        $videoSources = VideoSource::all();
        $event = $eventRoom->event;
        $pageTitle = __('Edit Event Room');

        return view('backend.rooms.edit', compact('event', 'videoSources', 'eventRoom', 'pageTitle'));
    }

    public function update(EventRoomStoreRequest $request, EventRoom $eventRoom): RedirectResponse
    {
        $this->authorize('update', $eventRoom);

        $attributes = $request->validated();
        (new EventRoomService)->update($eventRoom, $attributes);

        if (!$attributes['allow_all']) {
            (new EventRoomService)->attachRoomUsers($eventRoom, $attributes['room_participants']);
        }

        session()->flash('success', __('Event room was updated successfully.'));

        return redirect()->route('backend.rooms.edit', ['eventRoom' => $eventRoom->id]);
    }

    public function delete(EventRoom $eventRoom): RedirectResponse
    {
        $this->authorize('delete', $eventRoom);

        $eventRoom->delete();
        (new EventRoomService)->updateMenuOrders($eventRoom->event_id);
        session()->flash('success', __('Event room was deleted successfully.'));

        return redirect()->route('backend.rooms.index', ['event' => $eventRoom->event_id]);
    }

    public function bannerUpload(UploadMediaFileRequest $request, FileUploadHandler $fileUploadHandler, Event $event): JsonResponse
    {
        $this->authorize('create', [EventRoom::class, $event]);

        if (!$request->file('file')) {
            return response()->json([]);
        }

        $handledUpload = $fileUploadHandler->upload($request->file('file'), 'App\Models\EventRoom');

        return response()->json($handledUpload);
    }
}
