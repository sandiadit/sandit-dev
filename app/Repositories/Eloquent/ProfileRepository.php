<?php

namespace App\Repositories\Eloquent;

use App\Models\Profile;
use App\Repositories\Contracts\ProfileRepositoryInterface;

class ProfileRepository implements ProfileRepositoryInterface
{
    public function get(): ?Profile
    {
        return Profile::first();
    }

    public function updateOrCreate(array $data): Profile
    {
        $profile = Profile::first();

        if ($profile) {
            $profile->update($data);
            return $profile;
        }

        return Profile::create($data);
    }
}