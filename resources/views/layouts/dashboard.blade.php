<!DOCTYPE html>
<html>
<head>
    <title>Personal Hub - @yield('title')</title>
</head>
<body>

    {{-- Navbar atas --}}
    <nav style="display:flex; justify-content:space-between; align-items:center; padding:1rem; border-bottom:1px solid #ccc">
        <h3>Personal Hub</h3>

        <ul style="list-style:none; display:flex; gap:1rem; margin:0; padding:0">
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('profile.edit') }}">Profile</a></li>
            <li><a href="{{ route('dashboard.experiences.index') }}">Experiences</a></li>
            <li><a href="{{ route('dashboard.projects.index') }}">Projects</a></li>
            <li><a href="#">Docs</a></li>
            <li><a href="{{ route('contact') }}">Contact</a></li>
        </ul>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </nav>

    {{-- Content --}}
    <main style="padding:1rem">
        @yield('content')
    </main>

</body>
</html>