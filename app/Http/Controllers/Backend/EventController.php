<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\EventSlugGenerator;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventStoreRequest;
use App\Http\Requests\UploadMediaFileRequest;
use App\Models\Event;
use App\Models\Language;
use App\Models\Plan;
use App\Services\EventService;
use App\Services\FileUploadHandler;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    private const ITEMS_PER_PAGE = 20;

    public function index(Request $request): View
    {
        $this->authorize('seeList', Event::class);

        $attributes = [
            'id',
            'user_id',
            'plan_id',
            'title',
            'slug',
            'begin_datetime',
            'end_datetime',
            'is_public',
            'enabled'
        ];
        $events = (new EventService)->filter($request)
            ->ownedBy(auth()->user()->id)
            ->orderBy('begin_datetime', 'desc')
            ->paginate(self::ITEMS_PER_PAGE, $attributes);
        $pageTitle = __('My Events');

        return view('backend.events.index', compact('events', 'pageTitle'));
    }

    /**
     * @throws AuthorizationException
     */
    public function add(): View
    {
        $this->authorize('create', Event::class);

        $languages = Language::orderBy('name', 'asc')->get();
        $slug = EventSlugGenerator::generate('sample');
        $titleOptions = [
            [
                'id' => Event::TITLE_OPTION_SHOW_TITLE,
                'name' => __('Show title')
            ],
            [
                'id' => Event::TITLE_OPTION_SHOW_LOGO_AS_TITLE,
                'name' => __('Show logo instead of title')
            ],
            [
                'id' => Event::TITLE_OPTION_HIDE_TITLE,
                'name' => __('Hide title')
            ]
        ];

        return view('backend.events.add', compact('languages', 'titleOptions', 'slug'));
    }

    /**
     * @throws AuthorizationException
     */
    public function store(EventStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Event::class);

        $attributes = $request->validated();
        $attributes['plan_id'] = auth()->user()->isAdmin() ? Plan::PREMIUM : Plan::BASIC;
        $attributes['user_id'] = auth()->user()->id;
        $attributes['slug'] = EventSlugGenerator::generate($attributes['title']);
        $event = (new EventService)->create($attributes);
        session()->flash('success', __('Event was created successfully.'));

        return redirect()->route('backend.events.edit', ['event' => $event->id]);
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(Event $event): View
    {
        $this->authorize('edit', $event);

        $titleOptions = [
            [
                'id' => Event::TITLE_OPTION_SHOW_TITLE,
                'name' => __('Show title')
            ],
            [
                'id' => Event::TITLE_OPTION_SHOW_LOGO_AS_TITLE,
                'name' => __('Show logo instead of title')
            ],
            [
                'id' => Event::TITLE_OPTION_HIDE_TITLE,
                'name' => __('Hide title')
            ]
        ];
        $languages = Language::orderBy('name', 'asc')->get();
        $pageTitle = __('Edit Event');

        return view('backend.events.edit', compact('event', 'languages', 'titleOptions', 'pageTitle'));
    }

    /**
     * @throws AuthorizationException
     */
    public function delete(Event $event): RedirectResponse
    {
        $this->authorize('delete', $event);

        $event->delete();
        session()->flash('success', __('Event was deleted successfully.'));

        return redirect()->route('backend.events.index');
    }

    public function logoUpload(UploadMediaFileRequest $request, FileUploadHandler $fileUploadHandler): JsonResponse
    {
        $this->authorize('seeList', Event::class);

        if (!$request->file('file')) {
            return response()->json([]);
        }

        $handledUpload = $fileUploadHandler->upload($request->file('file'), 'App\Models\Event');

        return response()->json($handledUpload);
    }

    public function updateDesignSettings(Request $request, Event $event, EventService $eventService): RedirectResponse
    {
        $attributes = [
            'design_settings' => $request->settings ? json_encode($request->settings) : null
        ];
        $eventService->update($event, $attributes);
        session()->flash('success', __('Settings was saved.'));

        return back();
    }

    /**
     * @throws AuthorizationException
     */
    public function update(EventStoreRequest $request, Event $event): RedirectResponse
    {
        $this->authorize('update', $event);

        $attributes = $request->validated();
        (new EventService)->update($event, $attributes);
        session()->flash('success', __('Event was updated successfully.'));

        return redirect()->route('backend.events.edit', ['event' => $event->id]);
    }
}
