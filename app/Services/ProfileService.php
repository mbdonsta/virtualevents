<?php

namespace App\Services;

use App\Models\Profile;

class ProfileService
{
    public function create(array $profile): void
    {
        Profile::create($profile);
    }

    public function update(Profile $profile, array $data): void
    {
        $profile->update($data);
    }
}
