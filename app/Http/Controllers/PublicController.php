<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Repositories\Contracts\ExperienceRepositoryInterface;
use App\Repositories\Contracts\ProfileRepositoryInterface;
use App\Repositories\Contracts\ProjectRepositoryInterface;

class PublicController extends Controller
{
    public function __construct(
        private ProjectRepositoryInterface $projectRepository,
        private ExperienceRepositoryInterface $experienceRepository,
        private ProfileRepositoryInterface $profileRepository,
    ) {}

    public function home()
    {
        $profile = $this->profileRepository->get();
        $experiences = $this->experienceRepository->getAll();
        $allProjects = $this->projectRepository->getPublic();
        $latestProjects = $allProjects->take(3);
        $projectsCount = $allProjects->count();
        return view('public.home', compact('profile', 'experiences', 'latestProjects', 'projectsCount'));
    }

    public function projects()
    {
        $projects = $this->projectRepository->getPublic();
        return view('public.projects', compact('projects'));
    }

    public function projectDetail(Project $project)
    {
        $docs = $project->docs()->latest()->get();
        return view('public.project-detail', compact('project', 'docs'));
    }
}