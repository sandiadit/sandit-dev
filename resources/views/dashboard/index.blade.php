@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')

    {{-- Greeting --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">
            Welcome back, {{ auth()->user()->name }} 👋
        </h1>
        <p class="text-gray-500 text-sm mt-1">Kelola konten portfolio kamu dari sini.</p>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-10">

        {{-- Projects --}}
        <a href="{{ route('dashboard.projects.index') }}"
            class="bg-white border border-gray-200 rounded p-6 flex items-center gap-4 hover:border-indigo-400 hover:shadow-md transition group">
            <div class="w-12 h-12 bg-indigo-50 rounded flex items-center justify-center shrink-0 group-hover:bg-indigo-600 transition">
                <svg class="w-6 h-6 text-indigo-600 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <div>
                <p class="text-3xl font-black text-gray-900">{{ $stats['projects'] }}</p>
                <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold mt-0.5">Projects</p>
            </div>
        </a>

        {{-- Experiences --}}
        <a href="{{ route('dashboard.experiences.index') }}"
            class="bg-white border border-gray-200 rounded p-6 flex items-center gap-4 hover:border-indigo-400 hover:shadow-md transition group">
            <div class="w-12 h-12 bg-indigo-50 rounded flex items-center justify-center shrink-0 group-hover:bg-indigo-600 transition">
                <svg class="w-6 h-6 text-indigo-600 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <p class="text-3xl font-black text-gray-900">{{ $stats['experiences'] }}</p>
                <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold mt-0.5">Experiences</p>
            </div>
        </a>

        {{-- Certificates --}}
        <a href="{{ route('dashboard.certificates.index') }}"
            class="bg-white border border-gray-200 rounded p-6 flex items-center gap-4 hover:border-indigo-400 hover:shadow-md transition group">
            <div class="w-12 h-12 bg-indigo-50 rounded flex items-center justify-center shrink-0 group-hover:bg-indigo-600 transition">
                <svg class="w-6 h-6 text-indigo-600 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                </svg>
            </div>
            <div>
                <p class="text-3xl font-black text-gray-900">{{ $stats['certificates'] }}</p>
                <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold mt-0.5">Certificates</p>
            </div>
        </a>

    </div>

    {{-- Quick Actions --}}
    <div class="bg-white border border-gray-200 rounded p-6 mb-8">
        <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-widest mb-4">Quick Actions</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            <a href="{{ route('dashboard.projects.create') }}"
                class="flex items-center gap-2 px-4 py-3 border border-gray-200 rounded text-sm font-semibold text-gray-700 hover:bg-indigo-50 hover:border-indigo-300 hover:text-indigo-700 transition">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Project
            </a>
            <a href="{{ route('dashboard.experiences.create') }}"
                class="flex items-center gap-2 px-4 py-3 border border-gray-200 rounded text-sm font-semibold text-gray-700 hover:bg-indigo-50 hover:border-indigo-300 hover:text-indigo-700 transition">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Experience
            </a>
            <a href="{{ route('dashboard.certificates.create') }}"
                class="flex items-center gap-2 px-4 py-3 border border-gray-200 rounded text-sm font-semibold text-gray-700 hover:bg-indigo-50 hover:border-indigo-300 hover:text-indigo-700 transition">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Certificate
            </a>
            <a href="{{ route('profile.edit') }}"
                class="flex items-center gap-2 px-4 py-3 border border-gray-200 rounded text-sm font-semibold text-gray-700 hover:bg-indigo-50 hover:border-indigo-300 hover:text-indigo-700 transition">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Profile
            </a>
        </div>
    </div>

    {{-- Latest Projects --}}
    @if($latestProjects->count())
        <div class="bg-white border border-gray-200 rounded p-6">
            <div class="flex justify-between items-center mb-5">
                <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-widest">Latest Projects</h2>
                <a href="{{ route('dashboard.projects.index') }}"
                    class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition">
                    View All →
                </a>
            </div>
            <div class="space-y-3">
                @foreach($latestProjects as $project)
                    <div class="flex items-center gap-4 py-3 border-b border-gray-50 last:border-0">
                        @if($project->thumbnail)
                            <img src="{{ Storage::url($project->thumbnail) }}" alt=""
                                class="w-12 h-9 object-cover rounded border border-gray-100 shrink-0">
                        @else
                            <div class="w-12 h-9 bg-gray-100 rounded border border-gray-100 shrink-0 flex items-center justify-center">
                                <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm text-gray-900 truncate">{{ $project->title }}</p>
                            @if($project->tech_stack)
                                <p class="text-xs text-indigo-500 truncate mt-0.5">{{ $project->tech_stack }}</p>
                            @endif
                        </div>
                        <span class="text-[10px] font-semibold px-2 py-0.5 rounded shrink-0
                            {{ $project->status === 'completed' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $project->status === 'ongoing' ? 'bg-indigo-100 text-indigo-700' : '' }}
                            {{ $project->status === 'archived' ? 'bg-gray-100 text-gray-500' : '' }}">
                            {{ ucfirst($project->status) }}
                        </span>
                        <a href="{{ route('dashboard.projects.edit', $project) }}"
                            class="text-xs text-gray-400 hover:text-indigo-600 transition shrink-0">
                            Edit
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- View Site Link --}}
    <div class="mt-6 text-center">
        <a href="{{ route('home') }}" target="_blank"
            class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-indigo-600 transition font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
            Lihat Portfolio Publik
        </a>
    </div>

@endsection