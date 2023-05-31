<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'name',
        'content',
        'menu_order'
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function getContent(): array
    {
        return $this->content ? json_decode($this->content, 'true') : [];
    }

    public function getContentJson(): ?string
    {
        return $this->content;
    }
}
