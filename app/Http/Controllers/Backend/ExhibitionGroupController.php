<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExhibitionGroupStoreRequest;
use App\Models\Event;
use App\Models\ExhibitionGroup;
use App\Services\ExhibitionGroupService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExhibitionGroupController extends Controller
{
    private ExhibitionGroupService $exhibitionGroupService;

    public function __construct(ExhibitionGroupService $exhibitionGroupService)
    {
        $this->exhibitionGroupService = $exhibitionGroupService;
    }

    public function index(Event $event): View
    {
        $this->authorize('create', [ExhibitionGroup::class, $event]);

        $exhibitionGroups = $this->exhibitionGroupService->getByEvent($event->id);
        $pageTitle = __('Event Expo Groups');

        return view('backend.groups.index', compact('event', 'exhibitionGroups', 'pageTitle'));
    }

    public function add(Event $event): View
    {
        $this->authorize('create', [ExhibitionGroup::class, $event]);
        $pageTitle = __('Create Expo Group');

        return view('backend.groups.add', compact('event', 'pageTitle'));
    }

    public function store(ExhibitionGroupStoreRequest $request, Event $event): RedirectResponse
    {
        $this->authorize('create', [ExhibitionGroup::class, $event]);

        $attributes = $request->validated();
        $attributes['event_id'] = $event->id;
        $lastExhibitionGroup = $this->exhibitionGroupService->getLastByMenuOrder($event->id);
        $attributes['menu_order'] = $lastExhibitionGroup ? $lastExhibitionGroup->menu_order + 1 : 0;
        $exhibitionGroup = $this->exhibitionGroupService->create($attributes);
        session()->flash('success', __('Exhibition group was created successfully.'));

        return redirect()->route('backend.groups.edit', ['exhibitionGroup' => $exhibitionGroup->id]);
    }

    public function edit(ExhibitionGroup $exhibitionGroup): View
    {
        $this->authorize('edit', $exhibitionGroup);

        $event = $exhibitionGroup->event;
        $pageTitle = __('Edit Expo Group');

        return view('backend.groups.edit', compact('event', 'exhibitionGroup', 'pageTitle'));
    }

    public function update(ExhibitionGroupStoreRequest $request, ExhibitionGroup $exhibitionGroup): RedirectResponse
    {
        $this->authorize('update', $exhibitionGroup);

        $attributes = $request->validated();
        $this->exhibitionGroupService->update($exhibitionGroup, $attributes);
        session()->flash('success', __('Exhibition group was updated successfully.'));

        return redirect()->route('backend.groups.edit', ['exhibitionGroup' => $exhibitionGroup->id]);
    }

    public function delete(ExhibitionGroup $exhibitionGroup): RedirectResponse
    {
        $this->authorize('delete', $exhibitionGroup);

        $eventId = $exhibitionGroup->event_id;
        $this->exhibitionGroupService->delete($exhibitionGroup);
        session()->flash('success', __('Exhibition group was deleted successfully.'));

        return redirect()->route('backend.groups.index', ['event' => $eventId]);
    }
}
