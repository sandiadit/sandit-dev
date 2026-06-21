@extends('layouts.dashboard')

@section('title', isset($project) ? 'Edit Project' : 'Tambah Project')

@section('content')
    <div class="max-w-2xl">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">
                {{ isset($project) ? 'Edit Project' : 'Tambah Project' }}
            </h1>
            <p class="text-gray-500 text-sm mt-1">
                {{ isset($project) ? 'Ubah informasi project portfolio kamu.' : 'Tambahkan project baru ke portfolio kamu.' }}
            </p>
        </div>

        <form action="{{ isset($project) ? route('dashboard.projects.update', $project) : route('dashboard.projects.store') }}" method="POST" enctype="multipart/form-data" class="bg-white border border-gray-200 rounded p-6 md:p-8 space-y-6">
            @csrf
            @if(isset($project)) @method('PUT') @endif

            {{-- Title --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Title <span class="text-red-400">*</span></label>
                <input type="text" name="title" value="{{ old('title', $project->title ?? '') }}" required
                    class="w-full border border-gray-200 rounded px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="4"
                    class="w-full border border-gray-200 rounded px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition resize-none">{{ old('description', $project->description ?? '') }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Tech Stack & Status --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Tech Stack</label>
                    <input type="text" name="tech_stack" value="{{ old('tech_stack', $project->tech_stack ?? '') }}" placeholder="Laravel, Vue, Tailwind"
                        class="w-full border border-gray-200 rounded px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full border border-gray-200 rounded px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition bg-white">
                        @foreach(['ongoing', 'completed', 'archived'] as $s)
                            <option value="{{ $s }}" {{ old('status', $project->status ?? 'ongoing') === $s ? 'selected' : '' }}>
                                {{ ucfirst($s) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Links --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Repo URL</label>
                    <input type="url" name="repo_url" value="{{ old('repo_url', $project->repo_url ?? '') }}" placeholder="https://github.com/..."
                        class="w-full border border-gray-200 rounded px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                    @error('repo_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Demo URL</label>
                    <input type="url" name="demo_url" value="{{ old('demo_url', $project->demo_url ?? '') }}" placeholder="https://..."
                        class="w-full border border-gray-200 rounded px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                    @error('demo_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <hr class="border-gray-100">

            {{-- Thumbnail --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Thumbnail</label>
                @if(isset($project) && $project->thumbnail)
                    <div class="mb-3">
                        <img src="{{ Storage::url($project->thumbnail) }}" alt=""
                            class="w-48 h-28 object-cover rounded border border-gray-200">
                    </div>
                @endif
                <input type="file" name="thumbnail" accept="image/*"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:border file:border-gray-300 file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100 transition cursor-pointer">
                @if(isset($project) && $project->thumbnail)
                    <p class="text-xs text-gray-400 mt-2">Upload gambar baru untuk mengganti thumbnail.</p>
                @endif
                @error('thumbnail') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Submit --}}
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2.5 text-sm font-semibold rounded hover:bg-indigo-700 transition">
                    {{ isset($project) ? 'Update Project' : 'Simpan Project' }}
                </button>
                <a href="{{ route('dashboard.projects.index') }}" class="px-6 py-2.5 text-sm font-semibold rounded text-gray-600 hover:bg-gray-100 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection