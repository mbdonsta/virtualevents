<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventRoomBannerStoreRequest;
use App\Http\Requests\UploadFileRequest;
use App\Http\Requests\UploadMediaFileRequest;
use App\Models\Event;
use App\Models\EventRoom;
use App\Models\EventRoomBanner;
use App\Services\FileUploadHandler;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventRoomBannerController extends Controller
{
    public function add(EventRoom $eventRoom): View
    {
        $this->authorize('edit', $eventRoom);

        $bannerTypes = [
            EventRoomBanner::BANNER_TYPE_SIMPLE_IMAGE => __('Simple image'),
            EventRoomBanner::BANNER_TYPE_DOWNLOAD_FILE => __('On click - :type', ['type' => 'download file']),
            EventRoomBanner::BANNER_TYPE_REDIRECT_TO_URL => __('On click - :type', ['type' => 'redirect to url']),
            EventRoomBanner::BANNER_TYPE_YOUTUBE_VIDEO => __('On click - :type', ['type' => 'Pop up youtube video'])
        ];
        $event = $eventRoom->event;

        return view('backend.room_banners.add', compact('bannerTypes', 'eventRoom', 'event'));
    }

    public function store(EventRoomBannerStoreRequest $request, EventRoom $eventRoom): RedirectResponse
    {
        $this->authorize('edit', $eventRoom);
        $attributes = $request->validated();
        $lastItem = $eventRoom->banners()->latest('menu_order')->first();
        $attributes['menu_order'] = $lastItem ? $lastItem->menu_order + 1 : 0;
        $eventRoom->banners()->create($attributes);
        session()->flash('success', __('Room ad banner was created successfully.'));

        return redirect()->route('backend.rooms.edit', ['eventRoom' => $eventRoom->id]);
    }

    public function reorder(Request $request, EventRoom $eventRoom): JsonResponse
    {
        $this->authorize('edit', $eventRoom);
        $banners = collect($request->banners);
        $roomBanners = EventRoomBanner::where('event_room_id', $eventRoom->id)
            ->whereIn('id', $banners->pluck('id')->toArray())
            ->oldest('menu_order')
            ->get();

        foreach ($roomBanners as $roomBanner) {
            $roomBanner->update([
                'menu_order' => array_search($roomBanner->id, $banners->pluck('id')->toArray()) ? array_search($roomBanner->id, $banners->pluck('id')->toArray()) : 0
            ]);
        }

        return response()->json(['status' => 'OK']);
    }

    public function delete(EventRoomBanner $eventRoomBanner): JsonResponse
    {
        $this->authorize('edit', $eventRoomBanner->eventRoom);
        $eventRoom = $eventRoomBanner->eventRoom;
        $eventRoomBanner->delete();
        $this->reorderBanners($eventRoom->banners()->oldest('menu_order')->get());

        return response()->json(['status' => 'OK']);
    }

    private function reorderBanners(Collection $banners): void
    {
        foreach ($banners as $index => $banner) {
            $banner->update(['menu_order' => $index]);
        }
    }

    public function bannerUpload(UploadMediaFileRequest $request, FileUploadHandler $fileUploadHandler, EventRoom $eventRoom): JsonResponse
    {
        $this->authorize('edit', $eventRoom);

        if (!$request->file('file')) {
            return response()->json([]);
        }

        $handledUpload = $fileUploadHandler->upload($request->file('file'), 'App\Models\EventRoomBanner');

        return response()->json($handledUpload);
    }

    public function fileUpload(UploadFileRequest $request, FileUploadHandler $fileUploadHandler, EventRoom $eventRoom): JsonResponse
    {
        $this->authorize('edit', $eventRoom);

        if (!$request->file('file')) {
            return response()->json([]);
        }

        $handledUpload = $fileUploadHandler->upload($request->file('file'), 'App\Models\EventRoomBanner');

        return response()->json($handledUpload);
    }
}
