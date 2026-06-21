@extends('layouts.dashboard')

@section('title', 'Experiences')

@section('content')

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Experiences</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola riwayat pengalaman kamu.</p>
        </div>
        <a href="{{ route('dashboard.experiences.create') }}"
            class="bg-indigo-600 text-white px-4 py-2.5 text-sm font-semibold rounded hover:bg-indigo-700 transition">
            + Tambah Experience
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 px-4 py-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded">
            {{ session('success') }}
        </div>
    @endif

    @forelse($experiences as $exp)
        <div class="bg-white border border-gray-200 rounded p-4 md:p-6 mb-4 hover:border-indigo-300 transition group">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 md:gap-6">

                {{-- Content --}}
                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center gap-2 mb-1">
                        <h2 class="font-bold text-gray-900 group-hover:text-indigo-600 transition">
                            {{ $exp->title }}
                        </h2>
                        @if(!$exp->end_date)
                            <span class="text-[10px] font-semibold px-2 py-0.5 rounded bg-indigo-100 text-indigo-700">
                                Current
                            </span>
                        @endif
                    </div>
                    <p class="text-xs text-indigo-500 font-medium mb-1">{{ $exp->company }}</p>
                    <p class="text-xs text-gray-400 mb-2">
                        {{ $exp->start_date->format('M Y') }} —
                        {{ $exp->end_date ? $exp->end_date->format('M Y') : 'Present' }}
                    </p>
                    @if($exp->description)
                        <p class="text-xs md:text-sm text-gray-500 leading-relaxed line-clamp-2">
                            {{ $exp->description }}
                        </p>
                    @endif
                </div>

                {{-- Actions --}}
                <div
                    class="flex flex-wrap items-center gap-2 shrink-0 w-full md:w-auto pt-3 md:pt-0 border-t md:border-t-0 border-gray-100">
                    <a href="{{ route('dashboard.experiences.edit', $exp) }}"
                        class="flex-1 md:flex-none h-8 md:h-9 inline-flex items-center justify-center px-3 text-xs font-semibold border border-indigo-200 rounded text-indigo-600 hover:bg-indigo-50 transition">
                        Edit
                    </a>
                    <form action="{{ route('dashboard.experiences.destroy', $exp) }}" method="POST"
                        onsubmit="return confirm('Hapus experience ini?')" class="flex-1 md:flex-none m-0 p-0 flex">
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
            <p class="text-gray-400 text-sm">Belum ada experience.</p>
            <a href="{{ route('dashboard.experiences.create') }}"
                class="inline-block mt-4 text-sm font-semibold text-indigo-600 hover:text-indigo-700 transition">
                + Tambah experience pertama
            </a>
        </div>
    @endforelse

@endsection