@extends('layouts.dashboard')

@section('title', 'Docs — ' . $project->title)

@section('content')

    {{-- Header --}}
    <div class="mb-8">
        <a href="{{ route('dashboard.projects.index') }}"
            class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-indigo-600 transition mb-6 font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Projects
        </a>

        <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
            <div>
                <p class="text-indigo-600 text-xs font-semibold tracking-widest uppercase mb-1">Documentation</p>
                <h1 class="text-2xl font-bold text-gray-900">{{ $project->title }}</h1>
                <p class="text-gray-500 text-sm mt-1">Kelola catatan dan dokumentasi project ini.</p>
            </div>
            <a href="{{ route('dashboard.projects.docs.create', $project) }}"
                class="shrink-0 inline-flex items-center gap-2 bg-indigo-600 text-white px-4 py-2.5 text-sm font-semibold rounded hover:bg-indigo-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Doc
            </a>
        </div>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="mb-6 flex items-center gap-3 px-4 py-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded">
            <svg class="w-4 h-4 shrink-0 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Doc Cards --}}
    @forelse($docs as $doc)
        <div class="bg-white border border-gray-200 rounded p-5 md:p-6 mb-4 hover:border-indigo-300 hover:shadow-sm transition group">

            {{-- Top Row: Type badge + Actions --}}
            <div class="flex items-start justify-between gap-4 mb-3">
                <div class="flex items-center gap-2 flex-wrap">
                    {{-- Type Badge --}}
                    <span class="text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider
                        @if($doc->type === 'setup') bg-blue-100 text-blue-700
                        @elseif($doc->type === 'learning_note') bg-purple-100 text-purple-700
                        @elseif($doc->type === 'decision') bg-amber-100 text-amber-700
                        @elseif($doc->type === 'bug_fix') bg-red-100 text-red-700
                        @else bg-gray-100 text-gray-600
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $doc->type)) }}
                    </span>
                    {{-- Date --}}
                    <span class="text-xs text-gray-400 font-medium">{{ $doc->created_at->format('d M Y') }}</span>
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-2 shrink-0">
                    <a href="{{ route('dashboard.projects.docs.edit', [$project, $doc]) }}"
                        class="h-8 inline-flex items-center gap-1.5 px-3 text-xs font-semibold border border-indigo-200 rounded text-indigo-600 hover:bg-indigo-50 transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit
                    </a>
                    <form action="{{ route('dashboard.projects.docs.destroy', [$project, $doc]) }}"
                        method="POST"
                        onsubmit="return confirm('Hapus doc ini? Tindakan ini tidak dapat dibatalkan.')"
                        class="m-0 p-0 flex">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="h-8 inline-flex items-center gap-1.5 px-3 text-xs font-semibold border border-red-200 rounded text-red-500 hover:bg-red-50 transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>

            {{-- Title --}}
            <h2 class="font-bold text-gray-900 text-base group-hover:text-indigo-600 transition mb-3">
                {{ $doc->title }}
            </h2>

            {{-- Content Preview (rendered markdown) --}}
            <div class="prose prose-sm prose-gray max-w-none text-gray-600 leading-relaxed text-sm">
                {!! renderMarkdown($doc->content) !!}
            </div>

            {{-- Images --}}
            @if($doc->images && count($doc->images))
                <div class="flex flex-wrap gap-2 mt-4 pt-4 border-t border-gray-100">
                    @foreach($doc->images as $image)
                        <a href="{{ Storage::url($image) }}" target="_blank" class="block group/img">
                            <img src="{{ Storage::url($image) }}" alt=""
                                class="w-24 h-16 object-cover rounded border border-gray-200 group-hover/img:border-indigo-400 group-hover/img:scale-105 transition duration-200">
                        </a>
                    @endforeach
                    <p class="w-full text-xs text-gray-400 mt-1">
                        {{ count($doc->images) }} gambar · Klik untuk buka full size
                    </p>
                </div>
            @endif

        </div>
    @empty
        {{-- Empty State --}}
        <div class="bg-white border border-dashed border-gray-300 rounded p-12 text-center">
            <div class="w-14 h-14 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <p class="text-gray-500 font-medium text-sm mb-1">Belum ada dokumentasi</p>
            <p class="text-gray-400 text-xs mb-4">Mulai tambahkan catatan, setup guide, atau learning notes untuk project ini.</p>
            <a href="{{ route('dashboard.projects.docs.create', $project) }}"
                class="inline-flex items-center gap-2 bg-indigo-600 text-white px-4 py-2 text-sm font-semibold rounded hover:bg-indigo-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Doc Pertama
            </a>
        </div>
    @endforelse

@endsection