<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExhibitionGroup extends Model
{
    use HasFactory;

    private const COLUMN_GRID_COUNT = 12;
    private const DEFAULT_COLUMNS = 1;

    protected $fillable = [
        'event_id',
        'title',
        'columns',
        'menu_order'
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function exhibitionStands(): HasMany
    {
        return $this->hasMany(ExhibitionStand::class);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getColumns(): int
    {
        return $this->columns ? self::COLUMN_GRID_COUNT / $this->columns : self::DEFAULT_COLUMNS;
    }
}
