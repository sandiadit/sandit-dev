<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Repositories\Contracts\ExperienceRepositoryInterface;
use App\Repositories\Contracts\ProfileRepositoryInterface;
use App\Repositories\Contracts\ProjectRepositoryInterface;
use App\Repositories\Contracts\CertificateRepositoryInterface;

class PublicController extends Controller
{
    public function __construct(
        private ProjectRepositoryInterface $projectRepository,
        private ExperienceRepositoryInterface $experienceRepository,
        private ProfileRepositoryInterface $profileRepository,
        private CertificateRepositoryInterface $certificateRepository,
    ) {
    }

    public function home()
    {
        $profile = $this->profileRepository->get();
        $experiences = $this->experienceRepository->getAll();
        $projectsCount = $this->projectRepository->getPublic()->count();
        $latestProjects = $this->projectRepository->getPublic()->take(3);
        $featuredCertificates = $this->certificateRepository->getFeatured(); // tambah ini
        return view('public.home', compact('profile', 'experiences', 'projectsCount', 'latestProjects', 'featuredCertificates'));
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

    public function contact()
    {
        $profile = $this->profileRepository->get();
        return view('contact.index', compact('profile'));
    }

    public function certificates()
    {
        $certificates = $this->certificateRepository->getAll();
        return view('public.certificates', compact('certificates'));
    }
}