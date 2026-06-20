<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use App\Repositories\Contracts\ExperienceRepositoryInterface;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function __construct(
        private ExperienceRepositoryInterface $experienceRepository
    ) {}

    public function index()
    {
        $experiences = $this->experienceRepository->getAll();
        return view('dashboard.experiences.index', compact('experiences'));
    }

    public function create()
    {
        return view('dashboard.experiences.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'company'     => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date'  => 'required|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
        ]);

        $this->experienceRepository->create($validated);

        return redirect()->route('dashboard.experiences.index')
                         ->with('success', 'Experience berhasil ditambahkan.');
    }

    public function edit(Experience $experience)
    {
        return view('dashboard.experiences.form', compact('experience'));
    }

    public function update(Request $request, Experience $experience)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'company'     => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date'  => 'required|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
        ]);

        $this->experienceRepository->update($experience, $validated);

        return redirect()->route('dashboard.experiences.index')
                         ->with('success', 'Experience berhasil diupdate.');
    }

    public function destroy(Experience $experience)
    {
        $this->experienceRepository->delete($experience);

        return redirect()->route('dashboard.experiences.index')
                         ->with('success', 'Experience berhasil dihapus.');
    }
}