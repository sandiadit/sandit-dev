<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Repositories\Contracts\ProjectRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function __construct(
        private ProjectRepositoryInterface $projectRepository
    ) {}

    public function index()
    {
        $projects = $this->projectRepository->getAll();
        return view('dashboard.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('dashboard.projects.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'tech_stack'  => 'nullable|string|max:255',
            'repo_url'    => 'nullable|url',
            'demo_url'    => 'nullable|url',
            'status'      => 'required|in:ongoing,completed,archived',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        $this->projectRepository->create($validated);

        return redirect()->route('dashboard.projects.index')
                         ->with('success', 'Project berhasil ditambahkan.');
    }

    public function edit(Project $project)
    {
        return view('dashboard.projects.form', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'tech_stack'  => 'nullable|string|max:255',
            'repo_url'    => 'nullable|url',
            'demo_url'    => 'nullable|url',
            'status'      => 'required|in:ongoing,completed,archived',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        $this->projectRepository->update($project, $validated);

        return redirect()->route('dashboard.projects.index')
                         ->with('success', 'Project berhasil diupdate.');
    }

    public function destroy(Project $project)
    {
        $this->projectRepository->delete($project);

        return redirect()->route('dashboard.projects.index')
                         ->with('success', 'Project berhasil dihapus.');
    }
}