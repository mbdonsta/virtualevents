<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventProgramStoreRequest;
use App\Http\Requests\UploadMediaFileRequest;
use App\Models\Event;
use App\Models\EventProgram;
use App\Policies\EventProgramPolicy;
use App\Services\EventProgramService;
use App\Services\FileUploadHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventProgramController extends Controller
{
    private EventProgramService $eventProgramService;

    public function __construct(EventProgramService $eventProgramService)
    {
        $this->eventProgramService = $eventProgramService;
    }

    public function index(Event $event): View
    {
        $this->authorize('create', [EventProgram::class, $event]);

        $eventDays = $this->eventProgramService->getDaysByEvent($event->id);
        $pageTitle = __('Event Program');

        return view('backend.program.index', compact('event', 'eventDays', 'pageTitle'));
    }

    public function add(Event $event): View|RedirectResponse
    {
        $this->authorize('create', [EventProgram::class, $event]);
        if (count($event->eventProgram) >= $event->plan->maxEventDays()) {
            session()->flash('error', __('This event plan is limited to :num event day', ['num' => $event->plan->maxEventDays()]));

            return redirect()->route('backend.program.index', ['event' => $event->id]);
        }

        $pageTitle = __('Add Program Day');

        return view('backend.program.add', compact('event', 'pageTitle'));
    }

    public function store(EventProgramStoreRequest $request, Event $event): JsonResponse
    {
        $this->authorize('create', [EventProgram::class, $event]);
        if (count($event->eventProgram) >= $event->plan->maxEventDays()) {
            return response()->json([
                'status' => 'ERROR',
                'message' => __('This event plan is limited to :num event day', ['num' => $event->plan->maxEventDays()])
            ]);
        }

        $attributes = $request->validated();
        $attributes['event_id'] = $event->id;
        $this->eventProgramService->create($attributes);
        session()->flash('success', __('Event program day was created.'));

        return response()->json([
            'status' => 'OK',
            'message' => __('Event program day was created.'),
            'redirect' => route('backend.program.index', ['event' => $event->id])
        ]);
    }

    public function edit(EventProgram $eventProgram)
    {
        $this->authorize('edit', $eventProgram);

        $event = $eventProgram->event;
        $pageTitle = __('Edit Program Day');

        return view('backend.program.edit', compact('event', 'eventProgram', 'pageTitle'));
    }

    public function update(EventProgramStoreRequest $request, EventProgram $eventProgram): JsonResponse
    {
        $this->authorize('update', $eventProgram);

        $attributes = $request->validated();
        $this->eventProgramService->update($eventProgram, $attributes);
        session()->flash('success', __('Event program was updated successfully.'));

        return response()->json([
            'status' => 'OK',
            'message' => __('Event program was updated.'),
            'redirect' => route('backend.program.edit', ['eventProgram' => $eventProgram->id])
        ]);
    }

    public function delete(EventProgram $eventProgram): RedirectResponse
    {
        $this->authorize('edit', $eventProgram);
        $eventProgram->delete();
        session()->flash('success', __('Event program day was deleted successfully.'));

        return back();
    }

    public function programImageUpload(UploadMediaFileRequest $request, FileUploadHandler $fileUploadHandler): JsonResponse
    {
        if (!$request->file('file')) {
            return response()->json([]);
        }

        $handledUpload = $fileUploadHandler->upload($request->file('file'), 'App\Models\EventProgram');

        return response()->json($handledUpload);
    }
}
