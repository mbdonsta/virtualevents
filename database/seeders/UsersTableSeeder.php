<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Services\PermissionService;
use App\Services\ProfileService;
use App\Services\UserService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'model' => 'Event Manager',
                'data' => [
                    'email' => 'manager@donsta.eu',
                    'password' => bcrypt('123456'),
                    'role_id' => Role::EVENT_MANAGER_ROLE_ID,
                ],
                'profile' => [
                    'firstname' => 'Donatas',
                    'lastname' => 'Manageris'
                ]
            ],
            [
                'model' => 'Admin',
                'data' => [
                    'email' => 'donatas@donsta.eu',
                    'password' => bcrypt('429023'),
                    'role_id' => Role::ADMIN_ROLE_ID,
                ],
                'profile' => [
                    'firstname' => 'Donatas',
                    'lastname' => 'Stasiunas'
                ]
            ],
            [
                'model' => 'Admin',
                'data' => [
                    'email' => 'jurgita@seventips.lt',
                    'password' => bcrypt('jurgita1'),
                    'role_id' => Role::ADMIN_ROLE_ID,
                ],
                'profile' => [
                    'firstname' => 'Donatas',
                    'lastname' => 'Stasiunas'
                ]
            ],
        ];

        foreach ($users as $user) {
            $exist = User::where('email', $user['data']['email'])->first();

            if ($exist) {
                continue;
            }

            $createdUser = User::create($user['data']);
            $user['profile']['user_id'] = $createdUser->id;
            (new ProfileService)->create($user['profile']);
            (new PermissionService)->attachPermissionsToUser($createdUser->id, $createdUser->role->permissions);
        }
    }
}
