<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->get();
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

        Project::create($validated);

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

        $project->update($validated);

        return redirect()->route('dashboard.projects.index')
                         ->with('success', 'Project berhasil diupdate.');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('dashboard.projects.index')
                         ->with('success', 'Project berhasil dihapus.');
    }
}