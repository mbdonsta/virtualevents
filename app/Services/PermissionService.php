<?php

namespace App\Services;

use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\RolePermissionRelation;
use App\Models\UserPermissionRelation;
use Illuminate\Database\Eloquent\Collection;

class PermissionService
{
    public function createGroup(array $data): PermissionGroup
    {
        $group = PermissionGroup::where('slug', $data['slug'])->first();

        if (!$group) {
            $group = PermissionGroup::create($data);
        }

        return $group;
    }

    public function createPermission(array $data): void
    {
        $permission = Permission::where('slug', $data['slug'])->first();
        if (!$permission) {
            Permission::create($data);
        }
    }

    public function getGroups(): Collection
    {
        return PermissionGroup::with('permissions')->get();
    }

    public function getRolePermissions(int $roleId): array
    {
        return RolePermissionRelation::where('role_id', $roleId)
            ->get()
            ->pluck('permission_id')
            ->toArray();
    }

    public function attachPermissionsToUser(int $userId, array $permissions): void
    {
        foreach ($permissions as $permission) {
            $existingPermission = UserPermissionRelation::where('user_id', $userId)
                ->where('permission_id', $permission)->first();

            if (!$existingPermission) {
                UserPermissionRelation::create([
                    'user_id' => $userId,
                    'permission_id' => $permission
                ]);
            }
        }
    }
}
