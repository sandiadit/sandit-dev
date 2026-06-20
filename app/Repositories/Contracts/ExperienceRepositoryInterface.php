<?php

namespace App\Repositories\Contracts;

use App\Models\Experience;

interface ExperienceRepositoryInterface
{
    public function getAll();
    public function create(array $data): Experience;
    public function update(Experience $experience, array $data): Experience;
    public function delete(Experience $experience): void;
}