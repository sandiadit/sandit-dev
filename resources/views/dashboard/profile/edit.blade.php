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