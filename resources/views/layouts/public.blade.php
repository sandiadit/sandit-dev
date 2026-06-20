<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — Personal Hub</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Smooth scrolling behavior */
        html { scroll-behavior: smooth; }
        /* Custom Selection */
        ::selection { background: #6366f1; color: white; }
    </style>
    @stack('styles')
</head>
<body id="top" class="bg-[#fafafa] text-gray-900 font-sans antialiased overflow-x-hidden selection:bg-indigo-500 selection:text-white">

    {{-- Navbar --}}
    <nav class="fixed w-full top-0 z-50 bg-white/70 backdrop-blur-md border-b border-gray-200/50 transition-all duration-300 px-6 md:px-8 py-4 flex justify-between items-center">
        <a href="{{ request()->routeIs('home') ? '#top' : route('home') }}" class="text-xl font-black tracking-tighter flex items-center gap-1 group">
            sandi<span class="text-indigo-600 transition duration-300 group-hover:text-fuchsia-500">.</span>dev
            <span class="text-xl ml-1 group-hover:rotate-[20deg] transition duration-300">👋</span>
        </a>
        <ul class="hidden md:flex gap-8 text-sm font-semibold text-gray-600">
            <li><a href="{{ request()->routeIs('home') ? '#top' : route('home') }}" class="hover:text-indigo-600 transition relative after:absolute after:-bottom-1 after:left-0 after:w-0 after:h-0.5 after:bg-indigo-600 hover:after:w-full after:transition-all after:duration-300">Home</a></li>
            <li><a href="{{ request()->routeIs('home') ? '#projects' : route('home') . '#projects' }}" class="hover:text-indigo-600 transition relative after:absolute after:-bottom-1 after:left-0 after:w-0 after:h-0.5 after:bg-indigo-600 hover:after:w-full after:transition-all after:duration-300">Projects</a></li>
            <li><a href="{{ request()->routeIs('home') ? '#contact' : route('home') . '#contact' }}" class="hover:text-indigo-600 transition relative after:absolute after:-bottom-1 after:left-0 after:w-0 after:h-0.5 after:bg-indigo-600 hover:after:w-full after:transition-all after:duration-300">Contact</a></li>
        </ul>
        <div class="md:hidden">
            {{-- Mobile Menu Button (Optional to implement fully later, keeping simple for now) --}}
            <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </div>
    </nav>

    {{-- Content --}}
    <main class="pt-20">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-400 mt-24 px-8 py-12 border-t border-gray-800">
        <div class="max-w-5xl mx-auto flex flex-col md:flex-row justify-between items-center gap-6">
            <span class="text-white font-bold text-2xl tracking-tight">sandi<span class="text-indigo-500">.</span>dev</span>
            <span class="text-sm font-medium">© {{ date('Y') }} — Built with ☕ and Laravel</span>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>