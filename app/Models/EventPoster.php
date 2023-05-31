<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventPoster extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'poster_image_id',
        'author',
        'description',
        'youtube_url',
        'menu_order'
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(EventUserActivity::class, 'model_id')->where('activity', EventUserActivity::POSTER_VOTE);
    }

    public function posterImage(): BelongsTo
    {
        return $this->belongsTo(MediaFile::class, 'poster_image_id');
    }

    public function getPosterImageUrl(): string
    {
        return $this->posterImage && $this->posterImage->getUrl() ? $this->posterImage->getUrl() : '';
    }
}
