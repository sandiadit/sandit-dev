@extends('layouts.dashboard')

@section('title', isset($doc) ? 'Edit Doc' : 'Tambah Doc')

@section('content')
    <div style="margin-bottom:0.5rem">
        <a href="{{ route('dashboard.projects.docs.index', $project) }}">← Kembali ke Docs</a>
    </div>

    <h1 style="margin-bottom:1.5rem">
        {{ isset($doc) ? 'Edit Doc' : 'Tambah Doc' }} — {{ $project->title }}
    </h1>

    <form action="{{ isset($doc)
            ? route('dashboard.projects.docs.update', [$project, $doc])
            : route('dashboard.projects.docs.store', $project) }}"
          method="POST" style="max-width:600px">
        @csrf
        @if(isset($doc)) @method('PUT') @endif

        <div style="margin-bottom:1rem">
            <label>Title</label><br>
            <input type="text" name="title"
                   value="{{ old('title', $doc->title ?? '') }}"
                   style="width:100%; padding:0.5rem; margin-top:0.25rem">
            @error('title') <small style="color:red">{{ $message }}</small> @enderror
        </div>

        <div style="margin-bottom:1rem">
            <label>Type</label><br>
            <select name="type" style="width:100%; padding:0.5rem; margin-top:0.25rem">
                @foreach(['setup', 'learning_note', 'decision', 'bug_fix', 'general'] as $t)
                    <option value="{{ $t }}"
                        {{ old('type', $doc->type ?? 'general') === $t ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_', ' ', $t)) }}
                    </option>
                @endforeach
            </select>
            @error('type') <small style="color:red">{{ $message }}</small> @enderror
        </div>

        <div style="margin-bottom:1.5rem">
            <label>Content</label><br>
            <textarea name="content" rows="10"
                      style="width:100%; padding:0.5rem; margin-top:0.25rem; font-family:monospace">{{ old('content', $doc->content ?? '') }}</textarea>
            @error('content') <small style="color:red">{{ $message }}</small> @enderror
        </div>

        <div style="display:flex; gap:1rem">
            <button type="submit">{{ isset($doc) ? 'Update' : 'Simpan' }}</button>
            <a href="{{ route('dashboard.projects.docs.index', $project) }}">Batal</a>
        </div>
    </form>
@endsection