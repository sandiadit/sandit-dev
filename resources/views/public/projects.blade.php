@extends('layouts.public')

@section('title', 'Projects')

@section('content')

    {{-- Header --}}
    <section class="max-w-5xl mx-auto px-6 md:px-8 pt-20 pb-12">
        <p class="text-indigo-600 font-semibold text-sm tracking-widest uppercase mb-2">— Portfolio</p>
        <h1 class="text-4xl md:text-5xl font-bold">Things I've Built<span class="text-indigo-500">.</span></h1>
    </section>

    {{-- Projects List --}}
    <section class="max-w-5xl mx-auto px-6 md:px-8 pb-24">
        @forelse($projects as $index => $project)
            <a href="{{ route('projects.show', $project->slug) }}"
                class="group flex flex-col md:grid md:grid-cols-[80px_1fr] gap-4 md:gap-8 py-8 md:py-10 border-b border-gray-200 hover:bg-gray-50 transition px-4 -mx-4 rounded-lg">

                {{-- Nomor --}}
                <div class="text-gray-200 font-bold text-4xl md:text-6xl group-hover:text-indigo-100 transition leading-none pt-1 hidden md:block">
                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                </div>

                {{-- Info --}}
                <div>
                    {{-- Thumbnail --}}
                    @if($project->thumbnail)
                        <img src="{{ Storage::url($project->thumbnail) }}" alt="{{ $project->title }}"
                            class="w-full h-40 md:h-48 object-cover mb-4 rounded">
                    @endif

                    {{-- Header row: nomor mobile + title + badge --}}
                    <div class="flex items-start gap-3 mb-2">
                        <span class="text-gray-300 font-bold text-2xl leading-none md:hidden shrink-0">
                            {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                        </span>
                        <div class="flex flex-wrap items-center gap-2 min-w-0">
                            <h2 class="text-xl md:text-2xl font-bold group-hover:text-indigo-600 transition">
                                {{ $project->title }}
                            </h2>
                            <span class="text-xs font-medium px-2 py-0.5 rounded shrink-0
                                {{ $project->status === 'completed' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $project->status === 'ongoing' ? 'bg-indigo-100 text-indigo-700' : '' }}
                                {{ $project->status === 'archived' ? 'bg-gray-100 text-gray-500' : '' }}">
                                {{ ucfirst($project->status) }}
                            </span>
                        </div>
                    </div>

                    @if($project->tech_stack)
                        <p class="text-indigo-500 text-sm font-medium mb-3">{{ $project->tech_stack }}</p>
                    @endif

                    <p class="text-gray-500 leading-relaxed mb-4 text-sm md:text-base">{{ $project->description }}</p>

                    <div class="flex gap-4 text-sm font-medium">
                        @if($project->repo_url)
                            <span class="text-gray-400 group-hover:text-indigo-600 transition">
                                GitHub →
                            </span>
                        @endif
                        @if($project->demo_url)
                            <span class="text-gray-400 group-hover:text-indigo-600 transition">
                                Live Demo →
                            </span>
                        @endif
                    </div>
                </div>
            </a>
        @empty
            <p class="text-gray-400 py-12">Belum ada project.</p>
        @endforelse
    </section>

@endsection