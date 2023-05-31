<?php

namespace App\Services;


use App\Models\Event;
use App\Models\ExhibitionGroup;
use App\Models\ExhibitionStand;
use Illuminate\Database\Eloquent\Collection;

class ExhibitionGroupService
{
    public function create(array $data): ExhibitionGroup
    {
        return ExhibitionGroup::create($data);
    }

    public function update(ExhibitionGroup $exhibitionGroup, array $data): void
    {
        $exhibitionGroup->update($data);
    }

    public function delete(ExhibitionGroup $exhibitionGroup): void
    {
        $exhibitionGroup->delete();
    }

    public function getByEvent(int $eventId): Collection
    {
        return ExhibitionGroup::with(['exhibitionStands' => function ($q) {
            $q->orderBy('menu_order', 'asc');
        }])->where('event_id', $eventId)->orderBy('menu_order', 'asc')->get();
    }

    public function getLastByMenuOrder(int $eventId): ?ExhibitionGroup
    {
        return ExhibitionGroup::where('event_id', $eventId)->orderBy('menu_order', 'desc')->first();
    }
}
