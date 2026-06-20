<?php

namespace App\Repositories\Contracts;

use App\Models\Profile;

interface ProfileRepositoryInterface
{
    public function get(): ?Profile;
    public function updateOrCreate(array $data): Profile;
}