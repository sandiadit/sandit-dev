<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {
        $profile = Profile::first();
        return view('profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'headline' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'email' => 'nullable|email',
            'location' => 'nullable|string|max:255',
        ]);

        Profile::updateOrCreate(
            ['id' => 1],
            $request->only(['full_name', 'headline', 'bio', 'email', 'location'])
        );

        return redirect()->route('profile.edit')->with('success', 'Profile updated!');
    }
}