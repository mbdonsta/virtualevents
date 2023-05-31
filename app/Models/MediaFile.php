<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

class MediaFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'object_model',
        'original_name',
        'filename',
        'extension'
    ];

    public function eventRoom(): HasOne
    {
        return $this->hasOne(EventRoom::class, 'banner_file_id');
    }

    public function getUrl(): string
    {
        return file_exists(public_path('uploads') . '/' . $this->filename) ? url()->to('/') . '/uploads/' . $this->filename : '';
    }

    public function getFilename(): string
    {
        return $this->original_name;
    }
}
