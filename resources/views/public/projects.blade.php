@extends('layouts.public')

@section('title', 'Projects')

@section('content')
    <h1 style="margin-bottom:1.5rem">Projects</h1>

    @forelse($projects as $project)
        <div style="border:1px solid #ccc; padding:1.25rem; margin-bottom:1rem; border-radius:4px">
            <div style="display:flex; justify-content:space-between; align-items:start">
                <div>
                    <a href="{{ route('projects.show', $project->slug) }}"
                       style="font-size:1.1rem; font-weight:bold; text-decoration:none">
                        {{ $project->title }}
                    </a>
                    <span style="font-size:0.75rem; color:#888; margin-left:0.5rem">[{{ $project->status }}]</span>
                    @if($project->tech_stack)
                        <p style="font-size:0.85rem; color:#888; margin:0.25rem 0">{{ $project->tech_stack }}</p>
                    @endif
                    <p style="margin-top:0.5rem; color:#555">{{ $project->description }}</p>
                    <div style="display:flex; gap:1rem; margin-top:0.5rem; font-size:0.85rem">
                        @if($project->repo_url)
                            <a href="{{ $project->repo_url }}" target="_blank">Repo</a>
                        @endif
                        @if($project->demo_url)
                            <a href="{{ $project->demo_url }}" target="_blank">Demo</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <p style="color:#aaa">Belum ada project.</p>
    @endforelse
@endsection