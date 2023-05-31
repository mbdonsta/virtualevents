<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    public const BASIC = 1;
    public const STANDARD = 2;
    public const PREMIUM = 3;

    protected $fillable = [
        'name',
        'slug'
    ];

    public function event(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function isBasic(): bool
    {
        return $this->id === self::BASIC;
    }

    public function isStandard(): bool
    {
        return $this->id === self::STANDARD;
    }

    public function isPremium(): bool
    {
        return $this->id === self::PREMIUM;
    }

    public function getTypeSlug(): string
    {
        return match ($this->id) {
            self::STANDARD => 'info',
            self::PREMIUM => 'success',
            default => 'primary',
        };

    }

    public function maxEventDays(): int
    {
        return match ($this->id) {
            self::STANDARD => 2,
            self::PREMIUM => 3,
            default => 1,
        };
    }

    public function maxParticipants(): int
    {
        return match ($this->id) {
            self::STANDARD => 1000,
            self::PREMIUM => 1500,
            default => 500,
        };
    }

    public function maxRooms()
    {
        return match ($this->id) {
            self::STANDARD => 2,
            self::PREMIUM => 3,
            default => 1,
        };
    }
}
