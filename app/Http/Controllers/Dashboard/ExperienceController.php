<?php

namespace App\Http\Controllers\Dashboard;

// app/Http/Controllers/Dashboard/ExperienceController.php
use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function index()
    {
        $experiences = Experience::latest()->get();
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

        Experience::create($validated);

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

        $experience->update($validated);

        return redirect()->route('dashboard.experiences.index')
                         ->with('success', 'Experience berhasil diupdate.');
    }

    public function destroy(Experience $experience)
    {
        $experience->delete();

        return redirect()->route('dashboard.experiences.index')
                         ->with('success', 'Experience berhasil dihapus.');
    }
}
