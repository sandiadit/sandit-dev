<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — Personal Hub</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body id="top" class="bg-gray-50 text-gray-900 font-sans antialiased">

    {{-- Navbar --}}
    <nav class="bg-gray-900 text-white px-6 md:px-8 py-5 flex justify-between items-center sticky top-0 z-50">
        <a href="{{ request()->routeIs('home') ? '#top' : route('home') }}" class="text-xl font-bold tracking-tight">
            sandi<span class="text-indigo-400">.</span>dev
        </a>
        <ul class="flex gap-6 md:gap-8 text-sm font-medium text-gray-300">
            <li><a href="{{ request()->routeIs('home') ? '#top' : route('home') }}" class="hover:text-indigo-400 transition">Home</a></li>
            <li><a href="{{ request()->routeIs('home') ? '#projects' : route('home') . '#projects' }}" class="hover:text-indigo-400 transition">Projects</a></li>
            <li><a href="{{ request()->routeIs('home') ? '#contact' : route('home') . '#contact' }}" class="hover:text-indigo-400 transition">Contact</a></li>
        </ul>
    </nav>

    {{-- Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-400 mt-24 px-8 py-10">
        <div class="max-w-5xl mx-auto flex justify-between items-center">
            <span class="text-white font-bold text-lg">sandi<span class="text-indigo-400">.</span>dev</span>
            <span class="text-sm">© {{ date('Y') }} — Built with Laravel</span>
        </div>
    </footer>

</body>
</html>