<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventRoomBanner extends Model
{
    use HasFactory;

    public const BANNER_TYPE_SIMPLE_IMAGE = 1;
    public const BANNER_TYPE_DOWNLOAD_FILE = 2;
    public const BANNER_TYPE_REDIRECT_TO_URL = 3;
    public const BANNER_TYPE_YOUTUBE_VIDEO = 4;

    protected $fillable = [
        'event_room_id',
        'banner_type',
        'banner_image_id',
        'download_file_id',
        'banner_redirect_url',
        'youtube_url',
        'menu_order'
    ];

    protected $appends = ['banner_image_url', 'delete_route'];

    public function getRedirectUrl(): string
    {
        if (!$this->banner_redirect_url) {
            return '';
        }

        $url = $this->banner_redirect_url;

        if (!str_contains($url, 'http://')) {
            $url = 'http://' . $url;
        }

        return $url;
    }

    public function getBannerImageUrlAttribute(): string
    {
        return $this->getBannerImageUrl();
    }

    public function getBannerImageUrl(): string
    {
        return $this->bannerImage && $this->bannerImage->getUrl() ? $this->bannerImage->getUrl() : '';
    }

    public function getDeleteRouteAttribute(): string
    {
        return route('backend.room_banners.delete', ['eventRoomBanner' => $this->id]);
    }

    public function eventRoom(): BelongsTo
    {
        return $this->belongsTo(EventRoom::class);
    }

    public function bannerImage(): BelongsTo
    {
        return $this->belongsTo(MediaFile::class, 'banner_image_id');
    }

    public function downloadFile(): BelongsTo
    {
        return $this->belongsTo(MediaFile::class, 'download_file_id');
    }

    public function isTypeSimple(): bool
    {
        return $this->banner_type === self::BANNER_TYPE_SIMPLE_IMAGE;
    }

    public function isTypeDownloadFile(): bool
    {
        return $this->banner_type === self::BANNER_TYPE_DOWNLOAD_FILE;
    }

    public function isTypeRedirectToUrl(): bool
    {
        return $this->banner_type === self::BANNER_TYPE_REDIRECT_TO_URL;
    }

    public function isTypeYoutube(): bool
    {
        return $this->banner_type === self::BANNER_TYPE_YOUTUBE_VIDEO;
    }
}
