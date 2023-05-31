<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExhibitionStand extends Model
{
    use HasFactory;

    public const STAND_LAYOUTS = [
        1 => 4,
        2 => 2
    ];

    protected $fillable = [
        'event_id',
        'exhibition_group_id',
        'name',
        'media_file_id',
        'featured_image_id',
        'layout_style',
        'menu_order'
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function exhibitionGroup(): BelongsTo
    {
        return $this->belongsTo(ExhibitionGroup::class);
    }

    public function mediaFile(): BelongsTo
    {
        return $this->belongsTo(MediaFile::class);
    }

    public function featuredImage(): BelongsTo
    {
        return $this->belongsTo(MediaFile::class, 'featured_image_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(ExhibitionStandItem::class, 'exhibition_stand_id')
            ->oldest('menu_order');
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function canCreateItem(): bool
    {
        return true;
        return count($this->items) < self::STAND_LAYOUTS[$this->layout_style];
    }
}
