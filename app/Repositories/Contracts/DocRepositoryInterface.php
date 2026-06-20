<?php

namespace App\Repositories\Contracts;

use App\Models\Doc;
use App\Models\Project;

interface DocRepositoryInterface
{
    public function getByProject(Project $project);
    public function create(array $data): Doc;
    public function update(Doc $doc, array $data): Doc;
    public function delete(Doc $doc): void;
}