<?php

namespace App\Repositories\Eloquent;

use App\Models\Doc;
use App\Models\Project;
use App\Repositories\Contracts\DocRepositoryInterface;

class DocRepository implements DocRepositoryInterface
{
    public function getByProject(Project $project)
    {
        return $project->docs()->latest()->get();
    }

    public function create(array $data): Doc
    {
        return Doc::create($data);
    }

    public function update(Doc $doc, array $data): Doc
    {
        $doc->update($data);
        return $doc;
    }

    public function delete(Doc $doc): void
    {
        $doc->delete();
    }
}