<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExhibitionStandItemRequest;
use App\Http\Requests\ExhibitionStandStoreRequest;
use App\Http\Requests\UploadFileRequest;
use App\Http\Requests\UploadMediaFileRequest;
use App\Models\ExhibitionStand;
use App\Models\ExhibitionStandItem;
use App\Services\FileUploadHandler;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExhibitionStandItemController extends Controller
{
    public function add(ExhibitionStand $exhibitionStand): RedirectResponse|View
    {
        $this->authorize('create', [ExhibitionStandItem::class, $exhibitionStand->event]);

        if (!$exhibitionStand->canCreateItem()) {
            session()->flash('error', __('You have reached maximum stand items.'));

            return back();
        }

        $itemTypes = ExhibitionStandItem::getItemTypes();
        $event = $exhibitionStand->event;
        $pageTitle = __('Create Stand Item');

        return view('backend.stand_items.add', compact('itemTypes', 'exhibitionStand', 'event', 'pageTitle'));
    }

    public function store(ExhibitionStandItemRequest $request, ExhibitionStand $exhibitionStand): RedirectResponse
    {
        $this->authorize('create', [ExhibitionStandItem::class, $exhibitionStand->event]);

        $attributes = $request->validated();
        $lastItem = ExhibitionStandItem::where('exhibition_stand_id', $exhibitionStand->id)->latest('menu_order')->first();
        $attributes['exhibition_stand_id'] = $exhibitionStand->id;
        $attributes['menu_order'] = $lastItem ? $lastItem->menu_order + 1 : 0;
        ExhibitionStandItem::create($attributes);
        session()->flash('success', __('Stand item was created successfully.'));

        return redirect()->route('backend.stands.edit', ['exhibitionStand' => $exhibitionStand->id]);
    }

    public function edit(ExhibitionStandItem $exhibitionStandItem): View
    {
        $this->authorize('edit', $exhibitionStandItem);

        $itemTypes = ExhibitionStandItem::getItemTypes();
        $exhibitionStand = $exhibitionStandItem->exhibitionStand;
        $event = $exhibitionStand->event;
        $pageTitle = __('Edit Stand Item');
        $compact = compact('itemTypes', 'exhibitionStand', 'event', 'exhibitionStandItem', 'pageTitle');

        return view('backend.stand_items.edit', $compact);
    }

    public function delete(ExhibitionStandItem $exhibitionStandItem): RedirectResponse
    {
        $this->authorize('delete', $exhibitionStandItem);
        $exhibitionStand = $exhibitionStandItem->exhibitionStand;
        $exhibitionStandItem->delete();
        $this->reorderItems($exhibitionStand->items);
        session()->flash('success', __('Stand item was deleted successfully.'));

        return redirect()->route('backend.stands.edit', ['exhibitionStand' => $exhibitionStandItem->exhibition_stand_id]);
    }

    private function reorderItems(Collection $items): void
    {
        foreach ($items as $index => $item) {
            $item->update(['menu_order' => $index]);
        }
    }

    public function update(ExhibitionStandItemRequest $request, ExhibitionStandItem $exhibitionStandItem): RedirectResponse
    {
        $this->authorize('update', $exhibitionStandItem);

        $attributes = $request->validated();
        $filteredAttributes = $this->filterAttributesForUpdate($attributes);
        $exhibitionStandItem->update($filteredAttributes);
        session()->flash('success', __('Stand item was updated successfully.'));

        return redirect()->route('backend.stands.edit', ['exhibitionStand' => $exhibitionStandItem->exhibition_stand_id]);
    }

    private function filterAttributesForUpdate(array $attributes): array
    {
        switch ($attributes['item_type']) {
            case ExhibitionStandItem::ITEM_TYPE_DOWNLOAD_FILE_FROM_EXTERNAL_URL:
            case ExhibitionStandItem::ITEM_TYPE_REDIRECT_TO_URL:
            case ExhibitionStandItem::ITEM_TYPE_YOUTUBE:
                $attributes['download_file_id'] = null;
                break;
            case ExhibitionStandItem::ITEM_TYPE_BANNER_FROM_EXTERNAL_URL:
                $attributes['download_file_id'] = null;
                $attributes['banner_file_id'] = null;
                break;
            case ExhibitionStandItem::ITEM_TYPE_SIMPLE_BANNER:
                $attributes['download_file_id'] = null;
                $attributes['url'] = null;
                break;
            case ExhibitionStandItem::ITEM_TYPE_DOWNLOAD_FILE:
                $attributes['url'] = null;
                break;
        }

        return $attributes;
    }

    public function imageUpload(UploadMediaFileRequest $request, FileUploadHandler $fileUploadHandler, ExhibitionStand $exhibitionStand): JsonResponse
    {
        $this->authorize('edit', $exhibitionStand);

        if (!$request->file('file')) {
            return response()->json([]);
        }

        $handledUpload = $fileUploadHandler->upload($request->file('file'), 'App\Models\ExhibitionStandItem');

        return response()->json($handledUpload);
    }

    public function fileUpload(UploadFileRequest $request, FileUploadHandler $fileUploadHandler, ExhibitionStand $exhibitionStand): JsonResponse
    {
        $this->authorize('edit', $exhibitionStand);

        if (!$request->file('file')) {
            return response()->json([]);
        }

        $handledUpload = $fileUploadHandler->upload($request->file('file'), 'App\Models\ExhibitionStandItem');

        return response()->json($handledUpload);
    }

    public function reorder(Request $request, ExhibitionStand $exhibitionStand): JsonResponse
    {
        $this->authorize('edit', $exhibitionStand);
        $items = collect($request->items);
        $exhibitionStandItems = ExhibitionStandItem::where('exhibition_stand_id', $exhibitionStand->id)
            ->whereIn('id', $items->pluck('id')->toArray())
            ->oldest('menu_order')
            ->get();

        foreach ($exhibitionStandItems as $exhibitionStandItem) {
            $exhibitionStandItem->update([
                'menu_order' => array_search($exhibitionStandItem->id, $items->pluck('id')->toArray()) ? array_search($exhibitionStandItem->id, $items->pluck('id')->toArray()) : 0
            ]);
        }

        return response()->json(['status' => 'OK']);
    }
}
