<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class UserService
{
    private Builder $builder;
    private int $itemsPerPage = 20;

    public function __construct()
    {
        $this->builder = User::with('profile');
    }

    public function create(array $data): User
    {
        if (!isset($data['password'])) {
            $data['password'] = bcrypt(Str::random(8));
        }

        $user = User::create($data);
        $data['user_id'] = $user->id;
        (new ProfileService)->create($data);
        (new PermissionService)->attachPermissionsToUser($user->id, $user->role->permissions);

        return $user;
    }

    public function createMultiple(array $data): void
    {
        $userData = [];
        foreach ($data as $item) {
            $userData[] = [
                'email' => $item['email'],
                'password' => bcrypt(Str::random(8)),
                'role_id' => $item['role_id'],
            ];
        }
        User::insert($data);
    }

    public function update(User $user, array $data): User
    {
        $user->update($data['data']);
        (new ProfileService)->update($user->profile, $data['profile']);
        $user->permissionRelations()->delete();

        return $user;
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function getByEmails(array $emails = []): Collection
    {
        return User::whereIn('email', $emails)->get();
    }

    public function getAll(array $filter = []): LengthAwarePaginator
    {
        if (isset($filter['s'])) {
            $keyword = $filter['s'];
            $this->builder = $this->builder->whereHas('profile', function ($q) use ($keyword) {
                $q->where(function ($query) use ($keyword) {
                    $query->orWhere('firstname', 'like', '%' . $keyword . '%')
                        ->orWhere('lastname', 'like', '%' . $keyword . '%');
                });
            });
        }
        return $this->builder->paginate($this->itemsPerPage);
    }
}
