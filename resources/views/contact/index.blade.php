@extends('layouts.dashboard')

@section('title', 'Contact')

@section('content')
    <h1 style="margin-bottom:1.5rem">Contact</h1>

    <p>Feel free to reach out through any of the channels below.</p>

    <div style="margin-top:1.5rem; display:flex; flex-direction:column; gap:0.75rem">
        <div>
            📧 <strong>Email:</strong>
            <a href="mailto:youremail@gmail.com">youremail@gmail.com</a>
        </div>
        <div>
            🐙 <strong>GitHub:</strong>
            <a href="https://github.com/yourusername" target="_blank">github.com/yourusername</a>
        </div>
        <div>
            💼 <strong>LinkedIn:</strong>
            <a href="https://linkedin.com/in/yourusername" target="_blank">linkedin.com/in/yourusername</a>
        </div>
    </div>
@endsection