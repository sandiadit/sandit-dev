@extends('layouts.dashboard')

@section('title', 'Certificates')

@section('content')

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Certificates</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola sertifikat dan pencapaian kamu.</p>
        </div>
        <a href="{{ route('dashboard.certificates.create') }}"
            class="bg-indigo-600 text-white px-4 py-2.5 text-sm font-semibold rounded hover:bg-indigo-700 transition">
            + Tambah Certificate
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 px-4 py-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded">
            {{ session('success') }}
        </div>
    @endif

    @forelse($certificates as $cert)
        <div class="bg-white border border-gray-200 rounded p-4 md:p-6 mb-4 hover:border-indigo-300 transition group">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 md:gap-6">

                {{-- Image & Content --}}
                <div class="flex gap-4 md:gap-5 flex-1 min-w-0">
                    @if($cert->image)
                        <img src="{{ Storage::url($cert->image) }}" alt=""
                            class="w-16 h-12 md:w-20 md:h-14 object-cover rounded border border-gray-100 shrink-0">
                    @else
                        <div
                            class="w-16 h-12 md:w-20 md:h-14 bg-gray-100 rounded border border-gray-100 shrink-0 flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                        </div>
                    @endif

                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-2 mb-1">
                            <h2 class="font-bold text-gray-900 group-hover:text-indigo-600 transition truncate">
                                {{ $cert->name }}
                            </h2>
                            @if($cert->is_featured)
                                <span class="text-[10px] font-semibold px-2 py-0.5 rounded bg-amber-100 text-amber-700">
                                    Featured
                                </span>
                            @endif
                        </div>
                        <p class="text-xs text-indigo-500 font-medium mb-1">{{ $cert->issuer }}</p>
                        <p class="text-xs text-gray-400">
                            {{ $cert->issued_date->format('M Y') }}
                            @if($cert->expired_date)
                                — {{ $cert->expired_date->format('M Y') }}
                            @else
                                — No Expiry
                            @endif
                        </p>
                        @if($cert->credential_url)
                            <a href="{{ $cert->credential_url }}" target="_blank"
                                class="text-xs text-indigo-500 hover:text-indigo-700 transition mt-1 inline-block">
                                Verify ↗
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Actions --}}
                <div
                    class="flex flex-wrap items-center gap-2 shrink-0 w-full md:w-auto pt-3 md:pt-0 border-t md:border-t-0 border-gray-100">
                    <a href="{{ route('dashboard.certificates.edit', $cert) }}"
                        class="flex-1 md:flex-none h-8 md:h-9 inline-flex items-center justify-center px-3 text-xs font-semibold border border-indigo-200 rounded text-indigo-600 hover:bg-indigo-50 transition">
                        Edit
                    </a>
                    <form action="{{ route('dashboard.certificates.destroy', $cert) }}" method="POST"
                        onsubmit="return confirm('Hapus certificate ini?')" class="flex-1 md:flex-none m-0 p-0 flex">
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
            <p class="text-gray-400 text-sm">Belum ada certificate.</p>
            <a href="{{ route('dashboard.certificates.create') }}"
                class="inline-block mt-4 text-sm font-semibold text-indigo-600 hover:text-indigo-700 transition">
                + Tambah certificate pertama
            </a>
        </div>
    @endforelse

@endsection