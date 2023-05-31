<?php

namespace Database\Seeders;

use App\Services\PermissionService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissionGroups = [
            [
                'data' => [
                    'name' => 'System',
                    'slug' => 'system_permissions',
                ],
                'permissions' => [
                    [
                        'name' => 'Access admin',
                        'slug' => 'access_admin'
                    ],
                    [
                        'name' => 'Access backend',
                        'slug' => 'access_backend'
                    ],
                    [
                        'name' => 'Manage settings',
                        'slug' => 'manage_settings'
                    ]
                ]
            ],
            [
                'data' => [
                    'name' => 'Events',
                    'slug' => 'event_permissions',
                ],
                'permissions' => [
                    [
                        'name' => 'Create event',
                        'slug' => 'create_event'
                    ],
                    [
                        'name' => 'Manage owned events',
                        'slug' => 'manage_owned_events'
                    ]
                ]
            ],
        ];

        foreach ($permissionGroups as $group) {
            $permissionService = new PermissionService();
            $permissionGroup = $permissionService->createGroup($group['data']);
            foreach ($group['permissions'] as $permission) {
                $permission['permission_group_id'] = $permissionGroup->id;
                $permissionService->createPermission($permission);
            }
        }
    }
}
