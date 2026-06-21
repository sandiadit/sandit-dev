@extends('layouts.public')

@section('title', 'Certificates')

@section('content')

    <section class="max-w-5xl mx-auto px-6 md:px-8 pt-20 pb-12">
        <p class="text-indigo-600 font-semibold text-sm tracking-widest uppercase mb-2">— Achievements</p>
        <h1 class="text-5xl font-bold">Certificates<span class="text-indigo-500">.</span></h1>
    </section>

    <section class="max-w-5xl mx-auto px-6 md:px-8 pb-24">
        @forelse($certificates as $cert)
            <div class="flex flex-col md:flex-row gap-6 py-8 border-b border-gray-100 group">

                {{-- Image --}}
                <div class="shrink-0">
                    @if($cert->image)
                        <img src="{{ Storage::url($cert->image) }}" alt="{{ $cert->name }}"
                            class="w-full md:w-48 h-32 object-cover rounded border border-gray-200 group-hover:border-indigo-300 transition">
                    @else
                        <div
                            class="w-full md:w-48 h-32 bg-indigo-50 rounded border border-indigo-100 flex items-center justify-center">
                            <svg class="w-10 h-10 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                        </div>
                    @endif
                </div>

                {{-- Info --}}
                <div class="flex-1">
                    <div class="flex flex-wrap items-start justify-between gap-3 mb-2">
                        <div>
                            <h2 class="font-bold text-xl text-gray-900 group-hover:text-indigo-600 transition">
                                {{ $cert->name }}
                            </h2>
                            <p class="text-indigo-500 font-medium text-sm mt-0.5">{{ $cert->issuer }}</p>
                        </div>
                        @if($cert->is_featured)
                            <span class="text-xs font-semibold px-2 py-0.5 bg-amber-100 text-amber-700 rounded">
                                Featured
                            </span>
                        @endif
                    </div>

                    <p class="text-xs text-gray-400 mb-4">
                        {{ $cert->issued_date->format('M Y') }}
                        @if($cert->expired_date)
                            — Expires {{ $cert->expired_date->format('M Y') }}
                        @else
                            · No Expiry
                        @endif
                    </p>

                    @if($cert->credential_url)
                        <a href="{{ $cert->credential_url }}" target="_blank"
                            class="inline-flex items-center gap-1.5 text-xs font-bold text-indigo-600 hover:text-indigo-800 transition uppercase tracking-wider">
                            Verify Certificate
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-gray-400 py-12">Belum ada certificate.</p>
        @endforelse
    </section>

@endsection