<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Doc;
use App\Models\Project;
use Illuminate\Http\Request;

class DocController extends Controller
{
    public function index(Project $project)
    {
        $docs = $project->docs()->latest()->get();
        return view('dashboard.docs.index', compact('project', 'docs'));
    }

    public function create(Project $project)
    {
        return view('dashboard.docs.form', compact('project'));
    }

    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'type'    => 'required|in:setup,learning_note,decision,bug_fix,general',
        ]);

        $validated['project_id'] = $project->id;

        Doc::create($validated);

        return redirect()->route('dashboard.projects.docs.index', $project)
                         ->with('success', 'Doc berhasil ditambahkan.');
    }

    public function edit(Project $project, Doc $doc)
    {
        return view('dashboard.docs.form', compact('project', 'doc'));
    }

    public function update(Request $request, Project $project, Doc $doc)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'type'    => 'required|in:setup,learning_note,decision,bug_fix,general',
        ]);

        $doc->update($validated);

        return redirect()->route('dashboard.projects.docs.index', $project)
                         ->with('success', 'Doc berhasil diupdate.');
    }

    public function destroy(Project $project, Doc $doc)
    {
        $doc->delete();

        return redirect()->route('dashboard.projects.docs.index', $project)
                         ->with('success', 'Doc berhasil dihapus.');
    }
}