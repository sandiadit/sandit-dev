<?php

namespace App\Providers;

use App\Repositories\Contracts\DocRepositoryInterface;
use App\Repositories\Contracts\ExperienceRepositoryInterface;
use App\Repositories\Contracts\ProfileRepositoryInterface;
use App\Repositories\Contracts\ProjectRepositoryInterface;
use App\Repositories\Eloquent\DocRepository;
use App\Repositories\Eloquent\ExperienceRepository;
use App\Repositories\Eloquent\ProfileRepository;
use App\Repositories\Eloquent\ProjectRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);
        $this->app->bind(ExperienceRepositoryInterface::class, ExperienceRepository::class);
        $this->app->bind(DocRepositoryInterface::class, DocRepository::class);
        $this->app->bind(ProfileRepositoryInterface::class, ProfileRepository::class); // tambah ini
    }
}