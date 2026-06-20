@extends('layouts.dashboard')

@section('title', 'Profile')

@section('content')

    <h1>Edit Profile</h1>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label>Full Name</label><br>
            <input type="text" name="full_name" value="{{ old('full_name', $profile->full_name ?? '') }}" required>
        </div>

        <div>
            <label>Headline</label><br>
            <input type="text" name="headline" value="{{ old('headline', $profile->headline ?? '') }}">
        </div>

        <div>
            <label>Bio</label><br>
            <textarea name="bio">{{ old('bio', $profile->bio ?? '') }}</textarea>
        </div>

        <div>
            <label>Email</label><br>
            <input type="email" name="email" value="{{ old('email', $profile->email ?? '') }}">
        </div>

        <div>
            <label>Location</label><br>
            <input type="text" name="location" value="{{ old('location', $profile->location ?? '') }}">
        </div>

        {{-- Tambah ini --}}
        <div style="margin-top:1rem">
            <label>Photo</label><br>
            <input type="file" name="photo" accept="image/*" style="margin-top:0.25rem">
            @error('photo') <small style="color:red">{{ $message }}</small> @enderror

            @if(isset($profile) && $profile->photo)
                <div style="margin-top:0.75rem">
                    <img src="{{ Storage::url($profile->photo) }}" alt=""
                        style="width:100px; height:100px; object-fit:cover; border-radius:50%; border:1px solid #ccc">
                    <p style="font-size:0.75rem; color:#aaa; margin-top:0.25rem">Upload baru untuk mengganti foto</p>
                </div>
            @endif
        </div>

        <button type="submit" style="margin-top:1rem">Save</button>
    </form>

@endsection