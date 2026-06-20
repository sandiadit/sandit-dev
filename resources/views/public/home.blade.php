@extends('layouts.public')

@section('title', $profile->full_name ?? 'Home')

@section('content')
    {{-- Profile --}}
    @if($profile)
        <div style="margin-bottom:3rem">
            @if($profile->photo)
                <img src="{{ Storage::url($profile->photo) }}" alt=""
                     style="width:80px; height:80px; border-radius:50%; object-fit:cover; margin-bottom:1rem">
            @endif
            <h1 style="margin:0">{{ $profile->full_name }}</h1>
            <p style="color:#888; margin:0.25rem 0">{{ $profile->headline }}</p>
            @if($profile->location)
                <p style="color:#aaa; font-size:0.85rem">📍 {{ $profile->location }}</p>
            @endif
            <p style="margin-top:1rem; line-height:1.6">{{ $profile->bio }}</p>
        </div>
    @endif

    {{-- Experiences --}}
    @if($experiences->count())
        <div>
            <h2 style="margin-bottom:1rem">Experience</h2>
            @foreach($experiences as $exp)
                <div style="margin-bottom:1.5rem; padding-left:1rem; border-left:3px solid #ccc">
                    <strong>{{ $exp->title }}</strong> — {{ $exp->company }}<br>
                    <small style="color:#888">
                        {{ $exp->start_date->format('M Y') }} —
                        {{ $exp->end_date ? $exp->end_date->format('M Y') : 'Present' }}
                    </small>
                    @if($exp->description)
                        <p style="margin-top:0.5rem; color:#555">{{ $exp->description }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
@endsection