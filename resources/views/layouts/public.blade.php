<!DOCTYPE html>
<html>
<head>
    <title>@yield('title') — Personal Hub</title>
</head>
<body>

    <nav style="display:flex; justify-content:space-between; align-items:center; padding:1rem; border-bottom:1px solid #ccc">
        <a href="{{ route('home') }}" style="font-weight:bold; text-decoration:none">Personal Hub</a>
        <ul style="list-style:none; display:flex; gap:1.5rem; margin:0; padding:0">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('projects') }}">Projects</a></li>
            <li><a href="{{ route('contact') }}">Contact</a></li>
        </ul>
    </nav>

    <main style="max-width:800px; margin:0 auto; padding:2rem 1rem">
        @yield('content')
    </main>

</body>
</html>