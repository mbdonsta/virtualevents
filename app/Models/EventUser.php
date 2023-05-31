<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventUser extends Model
{
    use HasFactory;

    public const INVITED_STATUS = 1;

    protected $fillable = [
        'event_id',
        'user_id',
        'firstname',
        'lastname',
        'invited',
        'access_number'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function scopeInvited($query)
    {
        return $query->where('invited', self::INVITED_STATUS);
    }

    public function isInvited(): bool
    {
        return $this->invited === self::INVITED_STATUS;
    }

    public function getFullName(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }
}
