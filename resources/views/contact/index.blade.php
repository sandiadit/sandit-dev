@extends('layouts.public')

@section('title', 'Contact')

@section('content')

    {{-- Header --}}
    <section class="max-w-5xl mx-auto px-6 md:px-8 pt-20 pb-12">
        <p class="text-indigo-600 font-semibold text-sm tracking-widest uppercase mb-2">— Get In Touch</p>
        <h1 class="text-4xl md:text-5xl font-bold">Let's Talk<span class="text-indigo-500">.</span></h1>
    </section>

    {{-- Content --}}
    <section class="max-w-5xl mx-auto px-6 md:px-8 pb-24 grid grid-cols-1 md:grid-cols-2 gap-12 md:gap-16">

        {{-- Kiri - Text --}}
        <div>
            <p class="text-gray-500 leading-relaxed text-base md:text-lg mb-10">
                Have a project in mind, a question, or just want to say hi?
                Feel free to reach out through any of the channels below.
                I'll get back to you as soon as possible.
            </p>

            <div class="space-y-6">
                {{-- Email --}}
                @if($profile?->email)
                    <a href="mailto:{{ $profile->email }}" class="flex items-center gap-4 group">
                        <div class="w-12 h-12 bg-indigo-50 flex items-center justify-center group-hover:bg-indigo-600 transition shrink-0">
                            <svg class="w-5 h-5 text-indigo-600 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Email</p>
                            <p class="text-gray-900 font-semibold group-hover:text-indigo-600 transition">{{ $profile->email }}</p>
                        </div>
                    </a>
                @endif

                {{-- GitHub --}}
                @if($profile?->github_url)
                    <a href="{{ $profile->github_url }}" target="_blank" class="flex items-center gap-4 group">
                        <div class="w-12 h-12 bg-indigo-50 flex items-center justify-center group-hover:bg-indigo-600 transition shrink-0">
                            <svg class="w-5 h-5 text-indigo-600 group-hover:text-white transition" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C5.37 0 0 5.37 0 12c0 5.3 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 21.795 24 17.295 24 12c0-6.63-5.37-12-12-12"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">GitHub</p>
                            <p class="text-gray-900 font-semibold group-hover:text-indigo-600 transition truncate">{{ str_replace(['https://', 'http://'], '', $profile->github_url) }}</p>
                        </div>
                    </a>
                @endif

                {{-- LinkedIn --}}
                @if($profile?->linkedin_url)
                    <a href="{{ $profile->linkedin_url }}" target="_blank" class="flex items-center gap-4 group">
                        <div class="w-12 h-12 bg-indigo-50 flex items-center justify-center group-hover:bg-indigo-600 transition shrink-0">
                            <svg class="w-5 h-5 text-indigo-600 group-hover:text-white transition" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">LinkedIn</p>
                            <p class="text-gray-900 font-semibold group-hover:text-indigo-600 transition truncate">{{ str_replace(['https://', 'http://'], '', $profile->linkedin_url) }}</p>
                        </div>
                    </a>
                @endif

                {{-- Resume --}}
                @if($profile?->resume_url)
                    <a href="{{ $profile->resume_url }}" target="_blank" class="flex items-center gap-4 group">
                        <div class="w-12 h-12 bg-indigo-50 flex items-center justify-center group-hover:bg-indigo-600 transition shrink-0">
                            <svg class="w-5 h-5 text-indigo-600 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Resume / CV</p>
                            <p class="text-gray-900 font-semibold group-hover:text-indigo-600 transition">Download CV →</p>
                        </div>
                    </a>
                @endif
            </div>
        </div>

        {{-- Kanan - Dark Card --}}
        <div class="bg-gray-900 text-white p-8 md:p-10 flex flex-col justify-between">
            <div>
                <p class="text-indigo-400 font-semibold text-sm tracking-widest uppercase mb-4">— Availability</p>
                <h2 class="text-2xl md:text-3xl font-bold mb-4">Open for <br>Opportunities<span class="text-indigo-400">.</span></h2>
                <p class="text-gray-400 leading-relaxed text-sm md:text-base">
                    Currently available for freelance projects, collaborations,
                    or full-time opportunities. Let's build something great together.
                </p>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-700">
                <div class="flex items-center gap-3">
                    <div class="w-3 h-3 bg-green-500 flex items-center justify-center relative shrink-0">
                        <div class="w-3 h-3 bg-green-400 absolute animate-ping opacity-75"></div>
                    </div>
                    <p class="text-gray-300 font-medium text-sm tracking-wide">Available for work</p>
                </div>
            </div>
        </div>

    </section>

@endsection