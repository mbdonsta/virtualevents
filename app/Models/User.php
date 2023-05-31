<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'api_token',
        'role_id',
        'enabled'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($user) {
            if (!$user->permissionRelations->isEmpty()) {
                $user->permissionRelations()->delete();
            }

            if ($user->profile) {
                $user->profile->delete();
            }
        });
    }

    public function permissionRelations(): HasMany
    {
        return $this->hasMany(UserPermissionRelation::class);
    }

    public function getPermissionsAttribute(): array
    {
        $relations = $this->permissionRelations;
        $permissions = [];

        foreach ($relations as $relation) {
            $permissions[] = $relation->permission->slug;
        }

        return $permissions;
    }

    public function getPermissionsIdsAttribute(): array
    {
        $relations = $this->permissionRelations;
        $permissions = [];

        foreach ($relations as $relation) {
            $permissions[] = $relation->permission_id;
        }

        return $permissions;
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function profile(): HasOneOrMany
    {
        return $this->hasOne(Profile::class);
    }

    public function allowed($abilities): bool
    {
        $abilities = explode("|", $abilities);
        $userAbilities = $this->permissions;

        return !empty(array_intersect($userAbilities, $abilities));
    }

    public function isAttachedTo(int $eventId): bool
    {
        $attachedEventsIds = $this->attachedEvents()->pluck('event_id')->toArray();

        return in_array($eventId, $attachedEventsIds);
    }

    public function attachedEvents(): HasMany
    {
        return $this->hasMany(EventUser::class, 'user_id');
    }

    public function attachedEvent(): HasOne
    {
        return $this->hasOne(EventUser::class, 'user_id');
    }

    public function isAdmin(): bool
    {
        return $this->role_id === Role::ADMIN_ROLE_ID;
    }

    public function isParticipant(): bool
    {
        return $this->role_id === Role::PARTICIPANT_ROLE_ID;
    }

    public function isDisabled(): bool
    {
        return $this->enabled === UserStatus::STATUS_DISABLED;
    }

    public function isEnabled(): bool
    {
        return $this->enabled === UserStatus::STATUS_ENABLED;
    }

    public function getFullName(): string
    {
        return $this->profile->getName();
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
