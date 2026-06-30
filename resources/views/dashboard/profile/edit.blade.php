@extends('layouts.dashboard')

@section('title', 'Profile')

@section('content')

    <div class="max-w-2xl">

        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Edit Profile</h1>
            <p class="text-gray-500 text-sm mt-1">Informasi ini akan ditampilkan di halaman publik.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 px-4 py-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data"
            class="bg-white border border-gray-200 rounded p-8 space-y-6">
            @csrf
            @method('PUT')

            {{-- Photo --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">Photo</label>
                @if(isset($profile) && $profile->photo)
                    <div class="flex items-center gap-4 mb-3">
                        <img src="{{ Storage::url($profile->photo) }}" alt=""
                            class="w-16 h-16 object-cover rounded-full border border-gray-200">
                        <p class="text-xs text-gray-400">Upload baru untuk mengganti foto</p>
                    </div>
                @endif
                <input type="file" name="photo" accept="image/*"
                    class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:border file:border-gray-300 file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100 file:transition">
                @error('photo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <hr class="border-gray-100">

            {{-- Full Name --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Full Name <span
                        class="text-red-400">*</span></label>
                <input type="text" name="full_name" value="{{ old('full_name', $profile->full_name ?? '') }}" required
                    class="w-full border border-gray-200 rounded px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                @error('full_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Headline --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Headline</label>
                <input type="text" name="headline" value="{{ old('headline', $profile->headline ?? '') }}"
                    placeholder="misal: Fullstack Engineer"
                    class="w-full border border-gray-200 rounded px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
            </div>

            {{-- Bio --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Bio</label>
                <textarea name="bio" rows="4" placeholder="Ceritakan sedikit tentang dirimu..."
                    class="w-full border border-gray-200 rounded px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition resize-none">{{ old('bio', $profile->bio ?? '') }}</textarea>
            </div>

            {{-- Email & Location --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $profile->email ?? '') }}"
                        class="w-full border border-gray-200 rounded px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Location</label>
                    <input type="text" name="location" value="{{ old('location', $profile->location ?? '') }}"
                        placeholder="misal: Jakarta, Indonesia"
                        class="w-full border border-gray-200 rounded px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                </div>
            </div>

            <hr class="border-gray-100">

            {{-- Social Links --}}
            <div>
                <p class="text-sm font-semibold text-gray-700 mb-3">Social & Links</p>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">GitHub URL</label>
                        <div class="flex items-center border border-gray-200 rounded overflow-hidden focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500 transition">
                            <span class="px-3 py-2.5 bg-gray-50 border-r border-gray-200 text-gray-400 text-sm shrink-0">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.3 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 21.795 24 17.295 24 12c0-6.63-5.37-12-12-12"/></svg>
                            </span>
                            <input type="url" name="github_url" value="{{ old('github_url', $profile->github_url ?? '') }}"
                                placeholder="https://github.com/username"
                                class="flex-1 px-3 py-2.5 text-sm focus:outline-none bg-white">
                        </div>
                        @error('github_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">LinkedIn URL</label>
                        <div class="flex items-center border border-gray-200 rounded overflow-hidden focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500 transition">
                            <span class="px-3 py-2.5 bg-gray-50 border-r border-gray-200 text-gray-400 text-sm shrink-0">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                            </span>
                            <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $profile->linkedin_url ?? '') }}"
                                placeholder="https://linkedin.com/in/username"
                                class="flex-1 px-3 py-2.5 text-sm focus:outline-none bg-white">
                        </div>
                        @error('linkedin_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Resume / CV URL</label>
                        <div class="flex items-center border border-gray-200 rounded overflow-hidden focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500 transition">
                            <span class="px-3 py-2.5 bg-gray-50 border-r border-gray-200 text-gray-400 text-sm shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </span>
                            <input type="url" name="resume_url" value="{{ old('resume_url', $profile->resume_url ?? '') }}"
                                placeholder="https://drive.google.com/..."
                                class="flex-1 px-3 py-2.5 text-sm focus:outline-none bg-white">
                        </div>
                        @error('resume_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Submit --}}
            <div class="pt-2">
                <button type="submit"
                    class="bg-indigo-600 text-white px-6 py-2.5 text-sm font-semibold rounded hover:bg-indigo-700 transition">
                    Save Changes
                </button>
            </div>

        </form>
    </div>

@endsection