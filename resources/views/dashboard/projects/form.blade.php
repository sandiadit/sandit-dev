@extends('layouts.dashboard')

@section('title', isset($project) ? 'Edit Project' : 'Tambah Project')

@section('content')
    <h1 style="margin-bottom:1.5rem">
        {{ isset($project) ? 'Edit Project' : 'Tambah Project' }}
    </h1>

    <form action="{{ isset($project)
            ? route('dashboard.projects.update', $project)
            : route('dashboard.projects.store') }}"
          method="POST" style="max-width:500px">
        @csrf
        @if(isset($project)) @method('PUT') @endif

        <div style="margin-bottom:1rem">
            <label>Title</label><br>
            <input type="text" name="title"
                   value="{{ old('title', $project->title ?? '') }}"
                   style="width:100%; padding:0.5rem; margin-top:0.25rem">
            @error('title') <small style="color:red">{{ $message }}</small> @enderror
        </div>

        <div style="margin-bottom:1rem">
            <label>Description</label><br>
            <textarea name="description" rows="4"
                      style="width:100%; padding:0.5rem; margin-top:0.25rem">{{ old('description', $project->description ?? '') }}</textarea>
            @error('description') <small style="color:red">{{ $message }}</small> @enderror
        </div>

        <div style="margin-bottom:1rem">
            <label>Tech Stack <span style="color:#aaa">(misal: Laravel, MySQL, Tailwind)</span></label><br>
            <input type="text" name="tech_stack"
                   value="{{ old('tech_stack', $project->tech_stack ?? '') }}"
                   style="width:100%; padding:0.5rem; margin-top:0.25rem">
        </div>

        <div style="margin-bottom:1rem">
            <label>Repo URL</label><br>
            <input type="url" name="repo_url"
                   value="{{ old('repo_url', $project->repo_url ?? '') }}"
                   style="width:100%; padding:0.5rem; margin-top:0.25rem">
            @error('repo_url') <small style="color:red">{{ $message }}</small> @enderror
        </div>

        <div style="margin-bottom:1rem">
            <label>Demo URL</label><br>
            <input type="url" name="demo_url"
                   value="{{ old('demo_url', $project->demo_url ?? '') }}"
                   style="width:100%; padding:0.5rem; margin-top:0.25rem">
            @error('demo_url') <small style="color:red">{{ $message }}</small> @enderror
        </div>

        <div style="margin-bottom:1.5rem">
            <label>Status</label><br>
            <select name="status" style="width:100%; padding:0.5rem; margin-top:0.25rem">
                @foreach(['ongoing', 'completed', 'archived'] as $s)
                    <option value="{{ $s }}"
                        {{ old('status', $project->status ?? 'ongoing') === $s ? 'selected' : '' }}>
                        {{ ucfirst($s) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="display:flex; gap:1rem">
            <button type="submit">{{ isset($project) ? 'Update' : 'Simpan' }}</button>
            <a href="{{ route('dashboard.projects.index') }}">Batal</a>
        </div>
    </form>
@endsection