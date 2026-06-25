@extends('layouts.public')

@section('title', $project->title)

@section('content')

    {{-- Header --}}
    <section class="bg-gray-900 text-white px-5 md:px-8 py-12 md:py-20">
        <div class="max-w-5xl mx-auto">
            <a href="{{ route('projects') }}"
                class="text-gray-400 text-sm hover:text-indigo-400 transition mb-8 inline-block">
                ← Back to Projects
            </a>

            <div class="flex flex-col md:flex-row items-start gap-8 md:gap-10">

                {{-- Kiri: Thumbnail --}}
                @if($project->thumbnail)
                    <div class="shrink-0 w-full md:w-auto flex justify-center md:block">
                        <img src="{{ Storage::url($project->thumbnail) }}" alt="{{ $project->title }}"
                            class="w-32 h-32 md:w-48 md:h-48 object-contain opacity-90">
                    </div>
                @endif

                {{-- Tengah: Info --}}
                <div class="flex-1 text-center md:text-left">
                    <p class="text-indigo-400 font-semibold text-sm tracking-widest uppercase mb-3">
                        — Project Detail
                    </p>
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">
                        {{ $project->title }}<span class="text-indigo-400">.</span>
                    </h1>
                    @if($project->tech_stack)
                        <p class="text-indigo-400 text-sm font-medium mb-4">{{ $project->tech_stack }}</p>
                    @endif
                    <p class="text-gray-400 leading-relaxed max-w-xl mx-auto md:mx-0">{{ $project->description }}</p>
                </div>

                {{-- Kanan: Status & Links --}}
                <div class="shrink-0 flex flex-row md:flex-col gap-3 pt-2 w-full md:w-auto justify-center flex-wrap">
                    <span class="text-xs font-medium px-3 py-1 rounded text-center self-center md:self-stretch
                                {{ $project->status === 'completed' ? 'bg-green-500 text-white' : '' }}
                                {{ $project->status === 'ongoing' ? 'bg-indigo-500 text-white' : '' }}
                                {{ $project->status === 'archived' ? 'bg-gray-600 text-gray-300' : '' }}">
                        {{ ucfirst($project->status) }}
                    </span>
                    @if($project->repo_url)
                        <a href="{{ $project->repo_url }}" target="_blank"
                            class="bg-white text-gray-900 px-4 py-2 text-sm font-semibold hover:bg-indigo-400 hover:text-white transition text-center flex-1 md:flex-none">
                            GitHub →
                        </a>
                    @endif
                    @if($project->demo_url)
                        <a href="{{ $project->demo_url }}" target="_blank"
                            class="border border-white text-white px-4 py-2 text-sm font-semibold hover:bg-white hover:text-gray-900 transition text-center flex-1 md:flex-none">
                            Live Demo →
                        </a>
                    @endif
                </div>

            </div>
        </div>
    </section>

    {{-- Docs --}}
    <section class="max-w-5xl mx-auto px-5 md:px-8 py-12 md:py-20">
        @if($docs->count())
            <p class="text-indigo-600 font-semibold text-sm tracking-widest uppercase mb-2">— Documentation</p>
            <h2 class="text-3xl md:text-4xl font-bold mb-8 md:mb-12">Project Notes</h2>

            <div class="space-y-12">
                @foreach($docs as $doc)
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 md:gap-8">
                        {{-- Sidebar doc --}}
                        <div class="md:col-span-1 flex md:block items-center justify-between md:justify-start">
                            <span class="inline-block text-xs font-semibold px-2 py-1 bg-indigo-100 text-indigo-700 rounded md:mb-2">
                                {{ ucfirst(str_replace('_', ' ', $doc->type)) }}
                            </span>
                            <p class="text-gray-400 text-xs">
                                {{ $doc->created_at->format('d M Y') }}
                            </p>
                        </div>

                        {{-- Content doc --}}
                        <div class="md:col-span-3 md:border-l border-gray-200 md:pl-8 pt-2 md:pt-0">
                            <h3 class="text-xl font-bold mb-4">{{ $doc->title }}</h3>
                            <div class="prose prose-sm md:prose-base prose-gray max-w-none text-gray-600 leading-relaxed">
                                {!! renderMarkdown($doc->content) !!}
                            </div>

                            @if($doc->images)
                                <div class="flex flex-wrap gap-4 mt-6">
                                    @foreach($doc->images as $image)
                                        <img src="{{ Storage::url($image) }}" alt="" class="max-w-full rounded border border-gray-200">
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    @if(!$loop->last)
                        <hr class="border-gray-100">
                    @endif
                @endforeach
            </div>
        @else
            <p class="text-gray-400">Belum ada dokumentasi untuk project ini.</p>
        @endif
    </section>

@endsection