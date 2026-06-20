<?php

namespace App\Repositories\Eloquent;

use App\Models\Experience;
use App\Repositories\Contracts\ExperienceRepositoryInterface;

class ExperienceRepository implements ExperienceRepositoryInterface
{
    public function getAll()
    {
        return Experience::latest()->get();
    }

    public function create(array $data): Experience
    {
        return Experience::create($data);
    }

    public function update(Experience $experience, array $data): Experience
    {
        $experience->update($data);
        return $experience;
    }

    public function delete(Experience $experience): void
    {
        $experience->delete();
    }
}