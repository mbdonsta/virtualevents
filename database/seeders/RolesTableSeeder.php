<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'Participant'
            ],
            [
                'name' => 'Event Manager',
                'permissions' => [
                    'access_backend', 'create_event', 'manage_owned_events'
                ]
            ],
            [
                'name' => 'Admin'
            ]
        ];

        foreach ($roles as $role) {
            $existing = Role::where('name', $role['name'])->first();
            if (!$existing) {
                $existing = Role::create([
                    'name' => $role['name']
                ]);
            }

            if (isset($role['permissions']) && is_array($role['permissions'])) {
                foreach ($role['permissions'] as $permission) {
                    $rolePermissions = $existing->getPermissions();

                    if (!in_array($permission, $rolePermissions)) {
                        $existing->attachPermission($permission);
                    }
                }
            }
        }
    }
}
