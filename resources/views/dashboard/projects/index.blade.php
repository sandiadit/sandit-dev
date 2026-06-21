@extends('layouts.dashboard')

@section('title', 'Projects')

@section('content')

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Projects</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola portfolio project kamu.</p>
        </div>
        <a href="{{ route('dashboard.projects.create') }}"
            class="bg-indigo-600 text-white px-4 py-2.5 text-sm font-semibold rounded hover:bg-indigo-700 transition">
            + Tambah Project
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 px-4 py-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded">
            {{ session('success') }}
        </div>
    @endif

    @forelse($projects as $project)
        <div class="bg-white border border-gray-200 rounded p-4 md:p-6 mb-4 hover:border-indigo-300 transition group">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 md:gap-6">

                {{-- Thumbnail & Content --}}
                <div class="flex gap-4 md:gap-5 flex-1 min-w-0">
                    @if($project->thumbnail)
                        <img src="{{ Storage::url($project->thumbnail) }}" alt=""
                            class="w-16 h-12 md:w-20 md:h-14 object-cover rounded border border-gray-100 shrink-0">
                    @else
                        <div
                            class="w-16 h-12 md:w-20 md:h-14 bg-gray-100 rounded border border-gray-100 shrink-0 flex items-center justify-center">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif

                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-2 mb-1">
                            <h2 class="font-bold text-gray-900 group-hover:text-indigo-600 transition truncate max-w-full">
                                {{ $project->title }}
                            </h2>
                            <span
                                class="shrink-0 text-[10px] md:text-xs font-semibold px-2 py-0.5 rounded
                                                                        {{ $project->status === 'completed' ? 'bg-green-100 text-green-700' : '' }}
                                                                        {{ $project->status === 'ongoing' ? 'bg-indigo-100 text-indigo-700' : '' }}
                                                                        {{ $project->status === 'archived' ? 'bg-gray-100 text-gray-500' : '' }}">
                                {{ ucfirst($project->status) }}
                            </span>
                        </div>
                        @if($project->tech_stack)
                            <p class="text-[10px] md:text-xs text-indigo-500 font-medium mb-1 md:mb-2 line-clamp-1">
                                {{ $project->tech_stack }}</p>
                        @endif
                        <p class="text-xs md:text-sm text-gray-500 leading-relaxed line-clamp-2">{{ $project->description }}</p>
                        <div class="flex gap-3 md:gap-4 mt-2 md:mt-3 text-xs font-medium">
                            @if($project->repo_url)
                                <a href="{{ $project->repo_url }}" target="_blank"
                                    class="text-gray-400 hover:text-indigo-600 transition">Repo ↗</a>
                            @endif
                            @if($project->demo_url)
                                <a href="{{ $project->demo_url }}" target="_blank"
                                    class="text-gray-400 hover:text-indigo-600 transition">Demo ↗</a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div
                    class="flex flex-wrap items-center gap-2 shrink-0 w-full md:w-auto mt-1 md:mt-0 pt-3 md:pt-0 border-t md:border-t-0 border-gray-100">
                    <a href="{{ route('dashboard.projects.docs.index', $project) }}"
                        class="flex-1 md:flex-none h-8 md:h-9 inline-flex items-center justify-center px-3 text-xs font-semibold border border-gray-200 rounded text-gray-600 hover:bg-gray-50 transition">
                        Docs
                    </a>
                    <a href="{{ route('dashboard.projects.edit', $project) }}"
                        class="flex-1 md:flex-none h-8 md:h-9 inline-flex items-center justify-center px-3 text-xs font-semibold border border-indigo-200 rounded text-indigo-600 hover:bg-indigo-50 transition">
                        Edit
                    </a>
                    <form action="{{ route('dashboard.projects.destroy', $project) }}" method="POST"
                        onsubmit="return confirm('Hapus project ini?')" class="flex-1 md:flex-none m-0 p-0 flex">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="w-full h-8 md:h-9 inline-flex items-center justify-center px-3 text-xs font-semibold border border-red-200 rounded text-red-500 hover:bg-red-50 transition">
                            Hapus
                        </button>
                    </form>
                </div>

            </div>
        </div>
    @empty
        <div class="bg-white border border-dashed border-gray-300 rounded p-12 text-center">
            <p class="text-gray-400 text-sm">Belum ada project.</p>
            <a href="{{ route('dashboard.projects.create') }}"
                class="inline-block mt-4 text-sm font-semibold text-indigo-600 hover:text-indigo-700 transition">
                + Tambah project pertama
            </a>
        </div>
    @endforelse

@endsection