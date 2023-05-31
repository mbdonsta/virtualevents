<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExhibitionStandStoreRequest;
use App\Http\Requests\UploadMediaFileRequest;
use App\Models\Event;
use App\Models\ExhibitionStand;
use App\Services\ExhibitionGroupService;
use App\Services\ExhibitionStandService;
use App\Services\FileUploadHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ExhibitionStandController extends Controller
{
    private ExhibitionStandService $exhibitionStandService;
    private ExhibitionGroupService $exhibitionGroupService;

    public function __construct(ExhibitionStandService $exhibitionStandService, ExhibitionGroupService $exhibitionGroupService)
    {
        $this->exhibitionStandService = $exhibitionStandService;
        $this->exhibitionGroupService = $exhibitionGroupService;
    }

    public function index(Event $event): View
    {
        $this->authorize('create', [ExhibitionStand::class, $event]);

        $exhibitionStands = $this->exhibitionStandService->getByEvent($event->id);
        $pageTitle = __('Event Expo Stands');

        return view('backend.stands.index', compact('event', 'exhibitionStands', 'pageTitle'));
    }

    public function add(Event $event): View
    {
        $this->authorize('create', [ExhibitionStand::class, $event]);

        $exhibitionGroups = $this->exhibitionGroupService->getByEvent($event->id);
        $layouts = ExhibitionStand::STAND_LAYOUTS;
        $pageTitle = __('Create Expo Stand');

        return view('backend.stands.add', compact('event', 'exhibitionGroups', 'layouts', 'pageTitle'));
    }

    public function store(ExhibitionStandStoreRequest $request, Event $event): RedirectResponse
    {
        $this->authorize('create', [ExhibitionStand::class, $event]);

        $attributes = $request->validated();
        $attributes['event_id'] = $event->id;
        $lastExhibitionStand = $this->exhibitionStandService->getLastByMenuOrder($event->id);
        $attributes['menu_order'] = $lastExhibitionStand ? $lastExhibitionStand->menu_order + 1 : 0;
        $exhibitionStand = $this->exhibitionStandService->create($attributes);
        session()->flash('success', __('Exhibition stand was created successfully.'));

        return redirect()->route('backend.stands.edit', ['exhibitionStand' => $exhibitionStand->id]);
    }

    public function edit(ExhibitionStand $exhibitionStand): View
    {
        $this->authorize('edit', $exhibitionStand);

        $event = $exhibitionStand->event;
        $exhibitionGroups = $event->exhibitionGroups;
        $layouts = ExhibitionStand::STAND_LAYOUTS;
        $pageTitle = __('Edit Expo Stand');

        return view('backend.stands.edit', compact('event', 'exhibitionStand', 'exhibitionGroups', 'layouts', 'pageTitle'));
    }

    public function update(ExhibitionStandStoreRequest $request, ExhibitionStand $exhibitionStand): RedirectResponse
    {
        $this->authorize('update', $exhibitionStand);

        $attributes = $request->validated();
        $this->exhibitionStandService->update($exhibitionStand, $attributes);
        session()->flash('success', __('Exhibition stand was updated successfully.'));

        return redirect()->route('backend.stands.edit', ['exhibitionStand' => $exhibitionStand->id]);
    }

    public function delete(ExhibitionStand $exhibitionStand): RedirectResponse
    {
        $this->authorize('delete', $exhibitionStand);

        $eventId = $exhibitionStand->event_id;
        $this->exhibitionStandService->delete($exhibitionStand);
        session()->flash('success', __('Exhibition stand was deleted successfully.'));

        return redirect()->route('backend.stands.index', ['event' => $eventId]);
    }

    public function logoUpload(UploadMediaFileRequest $request, Event $event, FileUploadHandler $fileUploadHandler): JsonResponse
    {
        $this->authorize('create', [ExhibitionStand::class, $event]);

        if (!$request->file('file')) {
            return response()->json([]);
        }

        $handledUpload = $fileUploadHandler->upload($request->file('file'), 'App\Models\ExhibitionStand');

        return response()->json($handledUpload);
    }
}
