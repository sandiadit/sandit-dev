@extends('layouts.dashboard')

@section('title', 'Docs - ' . $project->title)

@section('content')
    <div style="margin-bottom:0.5rem">
        <a href="{{ route('dashboard.projects.index') }}">← Kembali ke Projects</a>
    </div>

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem">
        <h1>Docs — {{ $project->title }}</h1>
        <a href="{{ route('dashboard.projects.docs.create', $project) }}">+ Tambah Doc</a>
    </div>

    @if(session('success'))
        <p style="color:green; margin-bottom:1rem">{{ session('success') }}</p>
    @endif

    @forelse($docs as $doc)
        <div style="border:1px solid #ccc; padding:1rem; margin-bottom:1rem; border-radius:4px">
            <div style="display:flex; justify-content:space-between; align-items:start">
                <div>
                    <strong>{{ $doc->title }}</strong>
                    <span style="font-size:0.75rem; color:#888; margin-left:0.5rem">[{{ $doc->type }}]</span>
                    <p style="margin-top:0.5rem; white-space:pre-line">{{ $doc->content }}</p>
                </div>
                <div style="display:flex; gap:1rem; margin-left:1rem; shrink:0">
                    <a href="{{ route('dashboard.projects.docs.edit', [$project, $doc]) }}">Edit</a>
                    <form action="{{ route('dashboard.projects.docs.destroy', [$project, $doc]) }}"
                          method="POST" onsubmit="return confirm('Hapus doc ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" style="color:red; background:none; border:none; cursor:pointer">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <p style="color:#aaa">Belum ada doc untuk project ini.</p>
    @endforelse
@endsection