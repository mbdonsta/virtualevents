<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExhibitionStandItem extends Model
{
    use HasFactory;

    public const ITEM_TYPE_YOUTUBE = 1;
    public const ITEM_TYPE_BANNER_FROM_EXTERNAL_URL = 2;
    public const ITEM_TYPE_SIMPLE_BANNER = 3;
    public const ITEM_TYPE_DOWNLOAD_FILE_FROM_EXTERNAL_URL = 4;
    public const ITEM_TYPE_DOWNLOAD_FILE = 5;
    public const ITEM_TYPE_REDIRECT_TO_URL = 6;

    protected $fillable = [
        'exhibition_stand_id',
        'name',
        'item_type',
        'download_file_id',
        'banner_file_id',
        'url',
        'menu_order'
    ];

    public static function getItemTypeValues(): array
    {
        return [
            self::ITEM_TYPE_YOUTUBE,
            self::ITEM_TYPE_BANNER_FROM_EXTERNAL_URL,
            self::ITEM_TYPE_SIMPLE_BANNER,
            self::ITEM_TYPE_DOWNLOAD_FILE_FROM_EXTERNAL_URL,
            self::ITEM_TYPE_DOWNLOAD_FILE,
            self::ITEM_TYPE_REDIRECT_TO_URL
        ];
    }

    public function exhibitionStand(): BelongsTo
    {
        return $this->belongsTo(ExhibitionStand::class);
    }

    public function getBannerImageUrlAttribute(): string
    {
        return $this->getBannerImageUrl();
    }

    public function getBannerImageUrl(): string
    {
        if ($this->item_type === self::ITEM_TYPE_BANNER_FROM_EXTERNAL_URL) {
            return $this->url ? $this->url : '';
        }

        return $this->bannerImage && $this->bannerImage->getUrl() ? $this->bannerImage->getUrl() : '';
    }

    public function getDownloadFileUrl(): string
    {
        return $this->downloadFile && $this->downloadFile->getUrl() ? $this->downloadFile->getUrl() : '';
    }

    public function getDownloadFilename(): string
    {
        return $this->downloadFile && $this->downloadFile->getFilename() ? $this->downloadFile->getFilename() : '';
    }

    public function getOnClickBehaviour(): string
    {
        if (isset(self::getItemTypes()[$this->item_type])) {
            return self::getItemTypes()[$this->item_type];
        }

        return self::getItemTypes()[self::ITEM_TYPE_SIMPLE_BANNER];
    }

    public static function getItemTypes(): array
    {
        return [
            ExhibitionStandItem::ITEM_TYPE_SIMPLE_BANNER => __('None'),
//            ExhibitionStandItem::ITEM_TYPE_YOUTUBE => __('Youtube video popup'),
//            ExhibitionStandItem::ITEM_TYPE_BANNER_FROM_EXTERNAL_URL => __('Banner from external URL'),
//            ExhibitionStandItem::ITEM_TYPE_DOWNLOAD_FILE_FROM_EXTERNAL_URL => __('File download from external URL'),
            ExhibitionStandItem::ITEM_TYPE_DOWNLOAD_FILE => __('File download'),
//            ExhibitionStandItem::ITEM_TYPE_REDIRECT_TO_URL => __('Redirect to URL')
        ];
    }

    public function bannerImage(): BelongsTo
    {
        return $this->belongsTo(MediaFile::class, 'banner_file_id');
    }

    public function downloadFile(): BelongsTo
    {
        return $this->belongsTo(MediaFile::class, 'download_file_id');
    }
}
