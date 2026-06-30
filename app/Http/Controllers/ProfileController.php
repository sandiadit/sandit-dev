<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\ProfileRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function __construct(
        private ProfileRepositoryInterface $profileRepository
    ) {}

    public function edit()
    {
        $profile = $this->profileRepository->get();
        return view('dashboard.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'full_name'    => 'required|string|max:255',
            'headline'     => 'nullable|string|max:255',
            'bio'          => 'nullable|string',
            'email'        => 'nullable|email',
            'location'     => 'nullable|string|max:255',
            'photo'        => 'nullable|image|max:2048',
            'github_url'   => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'resume_url'   => 'nullable|url|max:255',
        ]);

        if ($request->hasFile('photo')) {
            $existing = $this->profileRepository->get();
            if ($existing?->photo) {
                Storage::disk('public')->delete($existing->photo);
            }
            $validated['photo'] = $request->file('photo')->store('profile', 'public');
        }

        $this->profileRepository->updateOrCreate($validated);

        return redirect()->route('profile.edit')
                         ->with('success', 'Profile berhasil diupdate.');
    }
}