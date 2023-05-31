<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventRoom extends Model
{
    use HasFactory, SoftDeletes;

    public const ENABLED_STATUS = 1;

    protected $fillable = [
        'event_id',
        'video_source_id',
        'name',
        'embed_id',
        'allow_all',
        'slido_url',
        'media_file_id',
        'show_banner',
        'menu_order',
        'enabled',
    ];

    public function scopeEnabled($query)
    {
        return $query->where('enabled', self::ENABLED_STATUS);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function eventRoomUsers(): HasMany
    {
        return $this->hasMany(EventRoomUser::class);
    }

    public function banners(): HasMany
    {
        return $this->hasMany(EventRoomBanner::class);
    }

    public function mediaFile(): BelongsTo
    {
        return $this->belongsTo(MediaFile::class);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStatus(): string
    {
        return $this->isEnabled() ? __('Enabled') : __('Disabled');
    }

    public function isEnabled(): bool
    {
        return $this->enabled === self::ENABLED_STATUS;
    }

    public function getStatusSlug(): string
    {
        return $this->isEnabled() ? 'light-success' : 'light-danger';
    }

    public function allowedToAll()
    {
        return $this->allow_all;
    }

    public function sourceYoutube(): bool
    {
        return $this->video_source_id === VideoSource::YOUTUBE_ID;
    }

    public function hasUser(int $userId): bool
    {
        return in_array($userId, $this->getParticipantIds());
    }

    public function getParticipantIds(): array
    {
        $ids = [];

        foreach ($this->eventRoomUsers as $eventUser) {
            $ids[] = $eventUser->user_id;
        }

        return $ids;
    }
}
