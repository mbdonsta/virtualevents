<?php

namespace App\Services;

use App\Models\EventProgram;
use Illuminate\Database\Eloquent\Collection;

class EventProgramService
{
    public function create(array $attributes): EventProgram
    {
        $lastOrder = EventProgram::where('event_id', $attributes['event_id'])->orderBy('menu_order', 'desc')->first();
        $attributes['menu_order'] = $lastOrder ? $lastOrder->menu_order + 1 : 0;
        
        return EventProgram::create($attributes);
    }

    public function update(EventProgram $eventProgram, array $attributes): void
    {
        $eventProgram->update($attributes);
    }

    public function getDaysByEvent(int $eventId): Collection
    {
        return EventProgram::where('event_id', $eventId)->orderBy('menu_order', 'desc')->get();
    }
}
