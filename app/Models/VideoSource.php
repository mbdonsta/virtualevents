<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoSource extends Model
{
    use HasFactory;

    public const YOUTUBE_ID = 1;
    public const VIMEO_ID = 2;

    protected $fillable = [
        'name'
    ];
}
