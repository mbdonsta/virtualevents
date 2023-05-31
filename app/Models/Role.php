<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    public const PARTICIPANT_ROLE_ID = 1;
    public const EVENT_MANAGER_ROLE_ID = 2;
    public const ADMIN_ROLE_ID = 3;

    protected $fillable = [
        'name'
    ];
    protected $appends = ['permissions'];

    public function getPermissionsAttribute(): array
    {
        $relations = $this->permissionRelations;
        $permissions = [];

        foreach ($relations as $relation) {
            $permissions[] = $relation->permission_id;
        }

        return $permissions;
    }

    public function permissionRelations(): HasMany
    {
        return $this->hasMany(RolePermissionRelation::class);
    }

    public function getPermissions(): array
    {
        return $this->permissionRelations()->with('permission')->get()->pluck('permission.slug')->toArray();
    }

    public function attachPermission($slug): void
    {
        $permission = Permission::where('slug', $slug)->first();

        if ($permission && !$this->permissionRelations()->where('permission_id', $permission->id)->first()) {
            RolePermissionRelation::create([
                'role_id' => $this->id,
                'permission_id' => $permission->id
            ]);
        }
    }
}
