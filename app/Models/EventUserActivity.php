<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventUserActivity extends Model
{
    use HasFactory;

    public const WATCHED_STREAM = 1;
    public const VISITED_PROGRAM = 2;
    public const VISITED_EXHIBITION = 3;
    public const VISITED_POSTERS = 4;
    public const VISITED_EXHIBITION_STAND = 5;
    public const POSTER_VOTE = 6;
    public const DEFAULT_VALUE = 1;

    protected $fillable = [
        'event_id',
        'event_user_id',
        'activity',
        'model_id',
        'activity_value'
    ];
}
