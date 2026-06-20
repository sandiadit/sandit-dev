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
                <div style="margin-top:0.5rem">
    {!! renderMarkdown($doc->content) !!}
</div>

                {{-- Tambah di sini --}}
                @if($doc->images)
                    <div style="display:flex; flex-wrap:wrap; gap:0.5rem; margin-top:0.75rem">
                        @foreach($doc->images as $image)
                            <img src="{{ Storage::url($image) }}" alt=""
                                 style="width:100px; height:70px; object-fit:cover; border:1px solid #ccc; border-radius:4px">
                        @endforeach
                    </div>
                @endif

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