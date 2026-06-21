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

                {{-- Preview area --}}
                <div id="thumbnailPreviewWrapper" class="{{ isset($project) && $project->thumbnail ? '' : 'hidden' }} mb-3 relative group/thumb inline-block">
                    <img
                        id="thumbnailPreview"
                        src="{{ isset($project) && $project->thumbnail ? Storage::url($project->thumbnail) : '' }}"
                        alt="Thumbnail preview"
                        class="w-48 h-28 object-cover rounded border border-gray-200">
                    <button
                        type="button"
                        id="clearThumbnail"
                        onclick="clearThumbnailPreview()"
                        class="absolute top-1 right-1 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center opacity-0 group-hover/thumb:opacity-100 transition text-xs leading-none">
                        ✕
                    </button>
                    <p id="thumbnailPreviewName" class="text-[10px] text-gray-400 mt-1 truncate max-w-[192px]"></p>
                </div>

                {{-- Drop zone (shown when no preview) --}}
                <label for="thumbnailInput"
                    id="thumbnailDropZone"
                    class="{{ isset($project) && $project->thumbnail ? 'hidden' : '' }} flex flex-col items-center justify-center w-full border-2 border-dashed border-gray-200 rounded-lg py-8 px-4 cursor-pointer hover:border-indigo-400 hover:bg-indigo-50/30 transition group">
                    <svg class="w-8 h-8 text-gray-300 group-hover:text-indigo-400 transition mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-sm text-gray-500 group-hover:text-indigo-600 transition font-medium">Klik untuk pilih thumbnail</p>
                    <p class="text-xs text-gray-400 mt-1">PNG, JPG, WEBP — maks. 2MB</p>
                    <input id="thumbnailInput" type="file" name="thumbnail" accept="image/*" class="hidden" onchange="previewThumbnail(this)">
                </label>

                @if(isset($project) && $project->thumbnail)
                    {{-- Hidden input still needs the file picker for edit mode --}}
                    <input id="thumbnailInput" type="file" name="thumbnail" accept="image/*" class="hidden" onchange="previewThumbnail(this)">
                    <button type="button" onclick="document.getElementById('thumbnailInput').click()"
                        class="mt-2 text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition">
                        Ganti Thumbnail
                    </button>
                @endif

                @error('thumbnail') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
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

@push('scripts')
<script>
    function previewThumbnail(input) {
        if (!input.files || !input.files[0]) return;
        const file = input.files[0];
        if (!file.type.startsWith('image/')) return;

        const reader = new FileReader();
        reader.onload = function (e) {
            const wrapper = document.getElementById('thumbnailPreviewWrapper');
            const preview = document.getElementById('thumbnailPreview');
            const nameEl  = document.getElementById('thumbnailPreviewName');
            const dropzone = document.getElementById('thumbnailDropZone');

            preview.src = e.target.result;
            nameEl.textContent = file.name;
            wrapper.classList.remove('hidden');
            if (dropzone) dropzone.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }

    function clearThumbnailPreview() {
        const wrapper  = document.getElementById('thumbnailPreviewWrapper');
        const preview  = document.getElementById('thumbnailPreview');
        const nameEl   = document.getElementById('thumbnailPreviewName');
        const dropzone = document.getElementById('thumbnailDropZone');
        const input    = document.getElementById('thumbnailInput');

        preview.src = '';
        nameEl.textContent = '';
        if (input) input.value = '';
        wrapper.classList.add('hidden');
        if (dropzone) dropzone.classList.remove('hidden');
    }
</script>
@endpush