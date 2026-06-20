@extends('layouts.dashboard')

@section('title', 'Projects')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem">
        <h1>Projects</h1>
        <a href="{{ route('dashboard.projects.create') }}">+ Tambah</a>
    </div>

    @if(session('success'))
        <p style="color:green; margin-bottom:1rem">{{ session('success') }}</p>
    @endif

    @forelse($projects as $project)
        <div style="border:1px solid #ccc; padding:1rem; margin-bottom:1rem; border-radius:4px">
            <div style="display:flex; justify-content:space-between; align-items:start">
                <div>
                    <strong>{{ $project->title }}</strong>
                    <span style="font-size:0.75rem; color:#888; margin-left:0.5rem">[{{ $project->status }}]</span><br>
                    <small style="color:#888">{{ $project->tech_stack }}</small>
                    <p style="margin-top:0.5rem">{{ $project->description }}</p>
                    <div style="display:flex; gap:1rem; margin-top:0.5rem; font-size:0.85rem">
                        @if($project->repo_url)
                            <a href="{{ $project->repo_url }}" target="_blank">Repo</a>
                        @endif
                        @if($project->demo_url)
                            <a href="{{ $project->demo_url }}" target="_blank">Demo</a>
                        @endif
                    </div>
                </div>
                <div style="display:flex; gap:1rem; margin-left:1rem">
                    <a href="{{ route('dashboard.projects.edit', $project) }}">Edit</a>
                    <form action="{{ route('dashboard.projects.destroy', $project) }}" method="POST"
                          onsubmit="return confirm('Hapus project ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" style="color:red; background:none; border:none; cursor:pointer">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <p style="color:#aaa">Belum ada project.</p>
    @endforelse
@endsection