@extends('layouts.public')

@section('title', $profile->full_name ?? 'Home')

@push('styles')
    <style>
        .reveal {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        .delay-100 {
            transition-delay: 100ms;
        }

        .delay-200 {
            transition-delay: 200ms;
        }
    </style>
@endpush

@section('content')

    {{-- Hero --}}
    <section id="hero"
        class="max-w-6xl mx-auto px-6 md:px-8 pt-16 md:pt-32 pb-16 md:pb-32 grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-center">

        {{-- Text --}}
        <div class="reveal order-2 md:order-1">
            <p class="text-indigo-600 font-semibold text-sm tracking-widest uppercase mb-4">
                — Introduction
            </p>
            <h1 class="text-4xl md:text-6xl font-bold leading-[1.1] text-gray-900 mb-6 tracking-tight">
                {{ $profile->full_name ?? 'Your Name' }}<span class="text-indigo-600">.</span>
            </h1>
            <p class="text-xl md:text-2xl text-gray-700 font-semibold mb-4 tracking-tight">
                {{ $profile->headline ?? 'Creative Developer & Analyst' }}
            </p>
            <p class="text-gray-500 text-base md:text-lg leading-relaxed mb-8 max-w-lg">
                {{ $profile->bio ?? 'Crafting digital experiences that matter. Designing systems and writing clean code.' }}
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="#projects"
                    class="bg-indigo-600 text-white px-6 py-3 font-semibold text-sm hover:bg-indigo-700 transition duration-300 shadow-sm">
                    View Projects →
                </a>
                <a href="#contact"
                    class="border border-gray-900 text-gray-900 px-6 py-3 font-semibold text-sm hover:bg-gray-900 hover:text-white transition duration-300 shadow-sm">
                    Contact Me
                </a>
            </div>
        </div>

        {{-- Photo --}}
        <div class="flex justify-center md:justify-end reveal delay-100 order-1 md:order-2">
            @if($profile?->photo)
                {{-- Mobile: simpler layout, Desktop: offset box effect --}}
                <div class="relative w-64 h-80 sm:w-72 sm:h-88 md:w-80 md:h-96 group">
                    <div
                        class="absolute bottom-0 right-0 w-full h-full bg-indigo-600 translate-x-3 translate-y-3 md:translate-x-4 md:translate-y-4 transition-transform duration-300 group-hover:translate-x-5 group-hover:translate-y-5 md:group-hover:translate-x-6 md:group-hover:translate-y-6">
                    </div>
                    <div
                        class="absolute top-0 left-0 w-16 h-16 md:w-24 md:h-24 bg-indigo-100 -translate-x-3 -translate-y-3 md:-translate-x-4 md:-translate-y-4 z-0">
                    </div>
                    <div class="relative z-10 w-full h-full overflow-hidden border border-gray-200 bg-white">
                        <img src="{{ Storage::url($profile->photo) }}" alt="{{ $profile->full_name }}"
                            class="w-full h-full object-cover grayscale-[30%] group-hover:grayscale-0 group-hover:scale-105 transition duration-500">
                    </div>
                </div>
            @else
                <div
                    class="w-64 h-80 sm:w-72 sm:h-88 md:w-80 md:h-96 bg-gray-100 border border-gray-300 flex items-center justify-center text-gray-400 text-sm font-semibold">
                    No Photo Found
                </div>
            @endif
        </div>
    </section>

    {{-- Stats / Info Bar --}}
    <section class="bg-gray-900 text-white py-10 md:py-12 px-6 md:px-8 reveal delay-200">
        <div class="max-w-5xl mx-auto grid grid-cols-3 gap-4 text-center divide-x divide-gray-800">
            <div class="px-2">
                <p class="text-3xl md:text-4xl font-bold text-indigo-400">{{ $experiences->count() }}</p>
                <p class="text-gray-400 text-xs md:text-sm mt-2 tracking-wider uppercase font-semibold">Experiences</p>
            </div>
            <div class="px-2">
                <p class="text-3xl md:text-4xl font-bold text-indigo-400">{{ $projectsCount ?? 0 }}</p>
                <p class="text-gray-400 text-xs md:text-sm mt-2 tracking-wider uppercase font-semibold">Projects</p>
            </div>
            <div class="px-2">
                @if($profile?->location)
                    <p class="text-2xl md:text-4xl font-bold text-indigo-400">📍</p>
                    <p class="text-gray-400 text-xs md:text-sm mt-2 tracking-wider uppercase font-semibold leading-tight">
                        {{ $profile->location }}</p>
                @endif
            </div>
        </div>
    </section>

    {{-- Experience --}}
    @if($experiences->count())
        <section class="max-w-5xl mx-auto px-6 md:px-8 py-16 md:py-24">
            <div class="mb-12 md:mb-16 reveal">
                <p class="text-indigo-600 font-semibold text-sm tracking-widest uppercase mb-2">— Experience</p>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 tracking-tight">Where I've Been</h2>
            </div>

            <div class="relative">
                {{-- Vertical line (desktop only) --}}
                <div class="absolute left-[180px] top-0 bottom-0 w-px bg-gray-200 hidden md:block"></div>

                <div class="space-y-0">
                    @foreach($experiences as $exp)
                        {{-- Mobile: stacked layout | Desktop: 2-col grid --}}
                        <div class="py-8 md:py-10 border-b border-gray-100 last:border-0 group reveal">

                            {{-- Mobile: date on top --}}
                            <div class="flex items-center gap-3 mb-3 md:hidden">
                                <div
                                    class="w-2 h-2 bg-gray-300 rounded-full group-hover:bg-indigo-600 transition duration-300 shrink-0">
                                </div>
                                <p class="text-sm font-semibold text-gray-500">
                                    {{ $exp->start_date->format('M Y') }}
                                    — {{ $exp->end_date ? $exp->end_date->format('M Y') : 'Present' }}
                                </p>
                            </div>

                            {{-- Desktop: grid layout --}}
                            <div class="hidden md:grid grid-cols-[180px_1fr] gap-12 relative">
                                <div class="text-right pr-10 relative">
                                    <p class="text-sm font-semibold text-gray-500">
                                        {{ $exp->start_date->format('M Y') }}
                                    </p>
                                    <p class="text-sm text-gray-400">
                                        {{ $exp->end_date ? $exp->end_date->format('M Y') : 'Present' }}
                                    </p>
                                    <div
                                        class="absolute -right-[5px] top-1.5 w-2.5 h-2.5 bg-white border-2 border-gray-300 rounded-full group-hover:border-indigo-600 group-hover:bg-indigo-600 transition duration-300">
                                    </div>
                                </div>
                                <div class="pl-10">
                                    <div class="flex items-start justify-between gap-4 mb-2">
                                        <div>
                                            <h3
                                                class="font-bold text-xl text-gray-900 group-hover:text-indigo-600 transition duration-300">
                                                {{ $exp->title }}
                                            </h3>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span class="text-gray-500 font-medium text-sm">{{ $exp->company }}</span>
                                                @if(!$exp->end_date)
                                                    <span
                                                        class="text-xs font-semibold px-2 py-0.5 bg-indigo-50 text-indigo-600 border border-indigo-100">Current</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @if($exp->description)
                                        <p class="text-gray-500 leading-relaxed mt-3 text-sm max-w-xl">{{ $exp->description }}</p>
                                    @endif
                                </div>
                            </div>

                            {{-- Mobile: content --}}
                            <div class="md:hidden pl-5">
                                <h3 class="font-bold text-lg text-gray-900 group-hover:text-indigo-600 transition duration-300">
                                    {{ $exp->title }}
                                </h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-gray-500 font-medium text-sm">{{ $exp->company }}</span>
                                    @if(!$exp->end_date)
                                        <span
                                            class="text-xs font-semibold px-2 py-0.5 bg-indigo-50 text-indigo-600 border border-indigo-100">Current</span>
                                    @endif
                                </div>
                                @if($exp->description)
                                    <p class="text-gray-500 leading-relaxed mt-3 text-sm">{{ $exp->description }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Projects Preview --}}
    @if(isset($latestProjects) && $latestProjects->count())
        <section id="projects" class="bg-gray-50 py-16 md:py-24 px-6 md:px-8 border-t border-gray-200">
            <div class="max-w-6xl mx-auto">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-10 md:mb-12 reveal gap-4">
                    <div>
                        <p class="text-indigo-600 font-semibold text-sm tracking-widest uppercase mb-2">— Featured Work</p>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 tracking-tight">Latest Projects</h2>
                    </div>
                    <a href="{{ route('projects') }}"
                        class="hidden md:inline-flex items-center gap-2 text-indigo-600 font-bold hover:text-indigo-800 transition group">
                        View All
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                    @foreach($latestProjects as $project)
                        <div
                            class="bg-white border border-gray-200 p-6 md:p-8 flex flex-col group hover:border-indigo-600 hover:shadow-xl transition duration-300 reveal">
                            <div class="flex justify-between items-start mb-5 md:mb-6">
                                <span class="text-xs font-bold px-2 py-1 bg-gray-100 text-gray-700 uppercase tracking-wider">
                                    {{ $project->status }}
                                </span>
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-indigo-600 transition" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </div>

                            <h3 class="text-xl md:text-2xl font-bold mb-3 text-gray-900 group-hover:text-indigo-600 transition">
                                {{ $project->title }}
                            </h3>
                            <p class="text-gray-500 text-sm mb-6 md:mb-8 flex-grow leading-relaxed">{{ $project->description }}</p>

                            <div class="flex flex-wrap gap-2 mb-6 md:mb-8">
                                @if($project->tech_stack)
                                    @foreach(explode(',', $project->tech_stack) as $tech)
                                        <span
                                            class="text-xs font-semibold text-indigo-600 bg-indigo-50 px-2 py-1 border border-indigo-100">{{ trim($tech) }}</span>
                                    @endforeach
                                @endif
                            </div>

                            <a href="{{ route('projects.show', $project->slug ?? '') }}"
                                class="text-sm font-bold text-gray-900 group-hover:text-indigo-600 transition uppercase tracking-widest mt-auto inline-flex items-center gap-2">
                                View Details
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 md:hidden reveal">
                    <a href="{{ route('projects') }}"
                        class="inline-flex items-center gap-2 border border-gray-900 text-gray-900 px-6 py-3 font-semibold text-sm w-full justify-center hover:bg-gray-900 hover:text-white transition">
                        View All Projects
                    </a>
                </div>
            </div>
        </section>
    @endif

    {{-- Featured Certificates --}}
    <section id="certificates" class="max-w-5xl mx-auto px-6 md:px-8 py-16 md:py-24">
        @if(isset($featuredCertificates) && $featuredCertificates->count())
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-10 md:mb-12 reveal gap-4">
                <div>
                    <p class="text-indigo-600 font-semibold text-sm tracking-widest uppercase mb-2">— Achievements</p>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 tracking-tight">Certificates</h2>
                </div>
                <a href="{{ route('certificates') }}"
                    class="hidden md:inline-flex items-center gap-2 text-indigo-600 font-bold hover:text-indigo-800 transition group">
                    View All
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 md:gap-6">
                @foreach($featuredCertificates as $cert)
                    <div
                        class="bg-white border border-gray-200 rounded p-4 md:p-5 flex flex-col gap-4 group hover:border-indigo-400 hover:shadow-md transition duration-300 reveal">

                        @if($cert->image)
                            <div class="overflow-hidden rounded border border-gray-100">
                                <img src="{{ Storage::url($cert->image) }}" alt="{{ $cert->name }}"
                                    class="w-full h-32 md:h-36 object-cover group-hover:scale-105 transition duration-500">
                            </div>
                        @else
                            <div
                                class="w-full h-32 md:h-36 bg-indigo-50 rounded border border-indigo-100 flex items-center justify-center">
                                <svg class="w-10 h-10 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                            </div>
                        @endif

                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900 group-hover:text-indigo-600 transition text-sm leading-snug mb-1">
                                {{ $cert->name }}
                            </h3>
                            <p class="text-xs text-indigo-500 font-medium mb-2">{{ $cert->issuer }}</p>
                            <p class="text-xs text-gray-400">
                                {{ $cert->issued_date->format('M Y') }}
                                @if($cert->expired_date)
                                    — {{ $cert->expired_date->format('M Y') }}
                                @else
                                    · No Expiry
                                @endif
                            </p>
                        </div>

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
                @endforeach
            </div>

            <div class="mt-8 md:hidden reveal">
                <a href="{{ route('certificates') }}"
                    class="inline-flex items-center gap-2 border border-gray-900 text-gray-900 px-6 py-3 font-semibold text-sm w-full justify-center hover:bg-gray-900 hover:text-white transition">
                    View All Certificates
                </a>
            </div>
        @else
            <p class="text-gray-400 text-center py-12">Belum ada certificate yang ditampilkan.</p>
        @endif
    </section>

    {{-- Contact --}}
    <section id="contact" class="bg-gray-900 text-white px-6 md:px-8 py-16 md:py-32">
        <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-16 reveal">
            <div>
                <p class="text-indigo-400 font-semibold text-sm tracking-widest uppercase mb-4">— Get In Touch</p>
                <h2 class="text-3xl md:text-5xl font-bold mb-6 tracking-tight">Let's Talk<span
                        class="text-indigo-400">.</span></h2>
                <p class="text-gray-400 leading-relaxed text-base md:text-lg mb-8 md:mb-10">
                    Have a project in mind or just want to say hi?
                    Feel free to reach out through any of the channels below.
                </p>
                <div class="space-y-5 md:space-y-6">
                    <a href="mailto:{{ $profile->email ?? 'youremail@gmail.com' }}"
                        class="flex items-center gap-4 md:gap-6 group">
                        <div
                            class="w-12 h-12 md:w-14 md:h-14 bg-gray-800 flex items-center justify-center border border-gray-700 group-hover:bg-indigo-600 group-hover:border-indigo-600 transition duration-300 shrink-0">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-gray-300 group-hover:text-white transition" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold mb-1">Email</p>
                            <p
                                class="text-white font-medium text-base md:text-lg group-hover:text-indigo-400 transition truncate">
                                {{ $profile->email ?? 'hello@domain.com' }}
                            </p>
                        </div>
                    </a>

                    <a href="https://github.com/sandiadit" target="_blank" class="flex items-center gap-4 md:gap-6 group">
                        <div
                            class="w-12 h-12 md:w-14 md:h-14 bg-gray-800 flex items-center justify-center border border-gray-700 group-hover:bg-indigo-600 group-hover:border-indigo-600 transition duration-300 shrink-0">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-gray-300 group-hover:text-white transition"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 0C5.37 0 0 5.37 0 12c0 5.3 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 21.795 24 17.295 24 12c0-6.63-5.37-12-12-12" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold mb-1">GitHub</p>
                            <p
                                class="text-white font-medium text-base md:text-lg group-hover:text-indigo-400 transition truncate">
                                github.com/sandiadit
                            </p>
                        </div>
                    </a>

                    <a href="https://linkedin.com/in/sandi-aditia" target="_blank"
                        class="flex items-center gap-4 md:gap-6 group">
                        <div
                            class="w-12 h-12 md:w-14 md:h-14 bg-gray-800 flex items-center justify-center border border-gray-700 group-hover:bg-indigo-600 group-hover:border-indigo-600 transition duration-300 shrink-0">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-gray-300 group-hover:text-white transition"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold mb-1">LinkedIn</p>
                            <p
                                class="text-white font-medium text-base md:text-lg group-hover:text-indigo-400 transition truncate">
                                linkedin.com/in/sandi-aditia
                            </p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="border border-gray-700 bg-gray-800/30 p-7 md:p-10 flex flex-col justify-between">
                <div>
                    <p class="text-indigo-400 font-semibold text-sm tracking-widest uppercase mb-4">— Availability</p>
                    <h3 class="text-2xl md:text-3xl font-bold mb-4">Open for<br>Opportunities<span
                            class="text-indigo-400">.</span></h3>
                    <p class="text-gray-400 leading-relaxed text-sm md:text-base">
                        Currently available for freelance projects, collaborations,
                        or full-time opportunities.
                    </p>
                </div>
                <div class="mt-8 pt-8 border-t border-gray-700 flex items-center gap-3">
                    <div class="w-3 h-3 bg-green-500 flex items-center justify-center relative shrink-0">
                        <div class="w-3 h-3 bg-green-400 absolute animate-ping opacity-75"></div>
                    </div>
                    <p class="text-gray-300 font-medium text-sm tracking-wide">Available for work</p>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const reveals = document.querySelectorAll('.reveal');
            const revealOnScroll = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1, rootMargin: "0px 0px -50px 0px" });

            reveals.forEach(r => revealOnScroll.observe(r));
        });
    </script>
@endpush