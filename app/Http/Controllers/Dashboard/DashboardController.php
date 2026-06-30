<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\CertificateRepositoryInterface;
use App\Repositories\Contracts\ExperienceRepositoryInterface;
use App\Repositories\Contracts\ProjectRepositoryInterface;

class DashboardController extends Controller
{
    public function __construct(
        private ProjectRepositoryInterface $projectRepository,
        private ExperienceRepositoryInterface $experienceRepository,
        private CertificateRepositoryInterface $certificateRepository,
    ) {}

    public function index()
    {
        $stats = [
            'projects'     => $this->projectRepository->getAll()->count(),
            'experiences'  => $this->experienceRepository->getAll()->count(),
            'certificates' => $this->certificateRepository->getAll()->count(),
        ];

        $latestProjects = $this->projectRepository->getAll()->take(3);

        return view('dashboard.index', compact('stats', 'latestProjects'));
    }
}
