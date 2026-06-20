@extends('layouts.dashboard')

@section('title', 'Experiences')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem">
        <h1>Experiences</h1>
        <a href="{{ route('dashboard.experiences.create') }}">+ Tambah</a>
    </div>

    @if(session('success'))
        <p style="color:green; margin-bottom:1rem">{{ session('success') }}</p>
    @endif

    @forelse($experiences as $exp)
        <div style="border:1px solid #ccc; padding:1rem; margin-bottom:1rem; border-radius:4px">
            <div style="display:flex; justify-content:space-between; align-items:start">
                <div>
                    <strong>{{ $exp->title }}</strong> — {{ $exp->company }}<br>
                    <small style="color:#888">
                        {{ $exp->start_date->format('M Y') }} —
                        {{ $exp->end_date ? $exp->end_date->format('M Y') : 'Present' }}
                    </small>
                    @if($exp->description)
                        <p style="margin-top:0.5rem">{{ $exp->description }}</p>
                    @endif
                </div>
                <div style="display:flex; gap:1rem; margin-left:1rem">
                    <a href="{{ route('dashboard.experiences.edit', $exp) }}">Edit</a>
                    <form action="{{ route('dashboard.experiences.destroy', $exp) }}" method="POST"
                          onsubmit="return confirm('Hapus experience ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" style="color:red; background:none; border:none; cursor:pointer">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <p style="color:#aaa">Belum ada experience.</p>
    @endforelse
@endsection