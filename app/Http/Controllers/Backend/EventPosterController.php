<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventPosterStoreRequest;
use App\Http\Requests\UploadMediaFileRequest;
use App\Models\Event;
use App\Models\EventPoster;
use App\Services\FileUploadHandler;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventPosterController extends Controller
{
    public function index(Event $event): View
    {
        $this->authorize('create', [EventPoster::class, $event]);
        $eventPosters = EventPoster::with(['votes', 'posterImage', 'event'])
            ->where('event_id', $event->id)
            ->oldest('menu_order')
            ->get();
        $pageTitle = __('Event Posters');

        return view('backend.posters.index', compact('event', 'eventPosters', 'pageTitle'));
    }

    public function add(Event $event): View
    {
        $this->authorize('create', [EventPoster::class, $event]);
        $pageTitle = __('Create Poster');

        return view('backend.posters.add', compact('event', 'pageTitle'));
    }

    public function store(EventPosterStoreRequest $request, Event $event): RedirectResponse
    {
        $this->authorize('create', [EventPoster::class, $event]);

        $attributes = $request->validated();
        $attributes['event_id'] = $event->id;
        $lastItem = EventPoster::where('event_id', $event->id)->latest('menu_order')->first();
        $attributes['menu_order'] = $lastItem ? $lastItem->menu_order + 1 : 0;
        EventPoster::create($attributes);
        session()->flash('success', __('Event poster was created successfully.'));

        return redirect()->route('backend.posters.index', ['event' => $event]);

    }

    public function edit(EventPoster $eventPoster): View
    {
        $this->authorize('edit', $eventPoster);

        $event = $eventPoster->event;
        $pageTitle = __('Edit Poster');

        return view('backend.posters.edit', compact('event', 'eventPoster', 'pageTitle'));
    }

    public function delete(EventPoster $eventPoster): RedirectResponse
    {
        $this->authorize('delete', $eventPoster);

        $event = $eventPoster->event;
        $eventPoster->delete();
        $this->reorderItems($event->eventPosters);
        session()->flash('success', __('Event poster was deleted successfully.'));

        return redirect()->route('backend.posters.index', ['event' => $event->id]);
    }

    private function reorderItems(Collection $items): void
    {
        foreach ($items as $index => $item) {
            $item->update(['menu_order' => $index]);
        }
    }

    public function update(EventPosterStoreRequest $request, EventPoster $eventPoster): RedirectResponse
    {
        $this->authorize('update', $eventPoster);

        $attributes = $request->validated();
        $eventPoster->update($attributes);
        session()->flash('success', __('Event poster was updated successfully.'));

        return redirect()->back();

    }

    public function imageUpload(UploadMediaFileRequest $request, FileUploadHandler $fileUploadHandler, Event $event): JsonResponse
    {
        $this->authorize('create', [EventPoster::class, $event]);

        if (!$request->file('file')) {
            return response()->json([]);
        }

        $handledUpload = $fileUploadHandler->upload($request->file('file'), 'App\Models\EventPoster');

        return response()->json($handledUpload);
    }

    public function reorder(Request $request, Event $event): JsonResponse
    {
        $this->authorize('edit', $event);
        $items = collect($request->items);
        $eventPosters = EventPoster::where('event_id', $event->id)
            ->whereIn('id', $items->pluck('id')->toArray())
            ->oldest('menu_order')
            ->get();

        foreach ($eventPosters as $eventPoster) {
            $eventPoster->update([
                'menu_order' => array_search($eventPoster->id, $items->pluck('id')->toArray()) ? array_search($eventPoster->id, $items->pluck('id')->toArray()) : 0
            ]);
        }

        return response()->json(['status' => 'OK']);
    }
}
