<?php

namespace App\Services;

use App\Models\ExhibitionStand;
use Illuminate\Database\Eloquent\Collection;

class ExhibitionStandService
{
    public function create(array $data): ExhibitionStand
    {
        return ExhibitionStand::create($data);
    }

    public function update(ExhibitionStand $exhibitionStand, array $data): ExhibitionStand
    {
        $exhibitionStand->update($data);

        return $exhibitionStand;
    }

    public function delete(ExhibitionStand $exhibitionStand): void
    {
        $exhibitionStand->items()->delete();
        $exhibitionStand->delete();
    }

    public function getByEvent(int $eventId): Collection
    {
        return ExhibitionStand::where('event_id', $eventId)->orderBy('menu_order', 'asc')->get();
    }

    public function getByGroup(int $exhibitionGroupId): Collection
    {
        return ExhibitionStand::where('exhibition_group_id', $exhibitionGroupId)->orderBy('menu_order', 'asc')->get();
    }

    public function getLastByMenuOrder(int $eventId): ?ExhibitionStand
    {
        return ExhibitionStand::where('event_id', $eventId)->orderBy('menu_order', 'desc')->first();
    }
}
