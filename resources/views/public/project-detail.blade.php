@extends('layouts.public')

@section('title', $project->title)

@section('content')
    <div style="margin-bottom:0.5rem">
        <a href="{{ route('projects') }}">← Kembali ke Projects</a>
    </div>

    {{-- Detail Project --}}
    <div style="margin-bottom:2.5rem">
        <h1 style="margin-bottom:0.25rem">{{ $project->title }}</h1>
        <span style="font-size:0.8rem; color:#888">[{{ $project->status }}]</span>
        @if($project->tech_stack)
            <p style="color:#888; font-size:0.9rem; margin-top:0.25rem">{{ $project->tech_stack }}</p>
        @endif
        <p style="margin-top:1rem; line-height:1.6">{{ $project->description }}</p>
        <div style="display:flex; gap:1rem; margin-top:0.75rem">
            @if($project->repo_url)
                <a href="{{ $project->repo_url }}" target="_blank">🔗 Repo</a>
            @endif
            @if($project->demo_url)
                <a href="{{ $project->demo_url }}" target="_blank">🌐 Demo</a>
            @endif
        </div>
    </div>

    {{-- Docs --}}
    @if($docs->count())
        <h2 style="margin-bottom:1.5rem">Documentation</h2>
        @foreach($docs as $doc)
            <div style="margin-bottom:2rem; padding-bottom:2rem; border-bottom:1px solid #eee">
                <div style="display:flex; align-items:center; gap:0.75rem; margin-bottom:0.75rem">
                    <h3 style="margin:0">{{ $doc->title }}</h3>
                    <span style="font-size:0.75rem; color:#888; background:#f0f0f0; padding:0.2rem 0.5rem; border-radius:4px">
                        {{ str_replace('_', ' ', $doc->type) }}
                    </span>
                </div>

                <div style="line-height:1.7">
                    {!! renderMarkdown($doc->content) !!}
                </div>

                @if($doc->images)
                    <div style="display:flex; flex-wrap:wrap; gap:0.75rem; margin-top:1rem">
                        @foreach($doc->images as $image)
                            <img src="{{ Storage::url($image) }}" alt=""
                                 style="max-width:100%; border:1px solid #ccc; border-radius:4px">
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    @else
        <p style="color:#aaa">Belum ada dokumentasi untuk project ini.</p>
    @endif
@endsection