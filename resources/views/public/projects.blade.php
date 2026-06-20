@extends('layouts.public')

@section('title', 'Projects')

@section('content')

    {{-- Header --}}
    <section class="max-w-5xl mx-auto px-8 pt-20 pb-12">
        <p class="text-indigo-600 font-semibold text-sm tracking-widest uppercase mb-2">— Portfolio</p>
        <h1 class="text-5xl font-bold">Things I've Built<span class="text-indigo-500">.</span></h1>
    </section>

    {{-- Projects List --}}
    <section class="max-w-5xl mx-auto px-8 pb-24">
        @forelse($projects as $index => $project)
            <a href="{{ route('projects.show', $project->slug) }}"
               class="group grid grid-cols-3 gap-8 py-10 border-b border-gray-200 hover:bg-gray-50 transition px-4 -mx-4">

                {{-- Nomor --}}
                <div class="text-gray-200 font-bold text-6xl group-hover:text-indigo-100 transition leading-none pt-1">
                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                </div>

                {{-- Info --}}
                <div class="col-span-2">
                    <div class="flex items-center gap-3 mb-2">
                        <h2 class="text-2xl font-bold group-hover:text-indigo-600 transition">
                            {{ $project->title }}
                        </h2>
                        <span class="text-xs font-medium px-2 py-1 rounded
                            {{ $project->status === 'completed' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $project->status === 'ongoing' ? 'bg-indigo-100 text-indigo-700' : '' }}
                            {{ $project->status === 'archived' ? 'bg-gray-100 text-gray-500' : '' }}">
                            {{ ucfirst($project->status) }}
                        </span>
                    </div>

                    @if($project->tech_stack)
                        <p class="text-indigo-500 text-sm font-medium mb-3">{{ $project->tech_stack }}</p>
                    @endif

                    <p class="text-gray-500 leading-relaxed mb-4">{{ $project->description }}</p>

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