<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Doc;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'title'    => 'required|string|max:255',
            'content'  => 'required|string',
            'type'     => 'required|in:setup,learning_note,decision,bug_fix,general',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('docs', 'public');
            }
        }

        Doc::create([
            'project_id' => $project->id,
            'title'      => $validated['title'],
            'content'    => $validated['content'],
            'type'       => $validated['type'],
            'images'     => $imagePaths ?: null,
        ]);

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
            'title'    => 'required|string|max:255',
            'content'  => 'required|string',
            'type'     => 'required|in:setup,learning_note,decision,bug_fix,general',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $imagePaths = $doc->images ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('docs', 'public');
            }
        }

        // Hapus gambar yang di-centang untuk dihapus
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $path) {
                Storage::disk('public')->delete($path);
                $imagePaths = array_filter($imagePaths, fn($p) => $p !== $path);
            }
        }

        $doc->update([
            'title'   => $validated['title'],
            'content' => $validated['content'],
            'type'    => $validated['type'],
            'images'  => array_values($imagePaths) ?: null,
        ]);

        return redirect()->route('dashboard.projects.docs.index', $project)
                         ->with('success', 'Doc berhasil diupdate.');
    }

    public function destroy(Project $project, Doc $doc)
    {
        // Hapus semua gambar terkait
        if ($doc->images) {
            foreach ($doc->images as $path) {
                Storage::disk('public')->delete($path);
            }
        }

        $doc->delete();

        return redirect()->route('dashboard.projects.docs.index', $project)
                         ->with('success', 'Doc berhasil dihapus.');
    }
}