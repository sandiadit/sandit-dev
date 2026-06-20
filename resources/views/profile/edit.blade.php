@extends('layouts.dashboard')

@section('title', 'Profile')

@section('content')

    <h1>Edit Profile</h1>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <form action="{{ route('profile.update') }}" method="POST">
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

        <button type="submit">Save</button>
    </form>

@endsection