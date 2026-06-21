@extends('layouts.dashboard')

@section('title', isset($doc) ? 'Edit Doc' : 'Tambah Doc')

@section('content')

    {{-- Back Link --}}
    <a href="{{ route('dashboard.projects.docs.index', $project) }}"
        class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-indigo-600 transition mb-6 font-medium">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke Docs
    </a>

    {{-- Page Header --}}
    <div class="mb-8">
        <p class="text-indigo-600 text-xs font-semibold tracking-widest uppercase mb-1">{{ $project->title }}</p>
        <h1 class="text-2xl font-bold text-gray-900">
            {{ isset($doc) ? 'Edit Doc' : 'Tambah Doc Baru' }}
        </h1>
        <p class="text-gray-500 text-sm mt-1">
            {{ isset($doc) ? 'Perbarui catatan dokumentasi project.' : 'Tambahkan catatan, setup guide, atau learning note baru.' }}
        </p>
    </div>

    <form action="{{ isset($doc)
            ? route('dashboard.projects.docs.update', [$project, $doc])
            : route('dashboard.projects.docs.store', $project) }}"
          method="POST"
          enctype="multipart/form-data"
          class="max-w-2xl">
        @csrf
        @if(isset($doc)) @method('PUT') @endif

        <div class="bg-white border border-gray-200 rounded p-6 md:p-8 space-y-6">

            {{-- Title --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Judul <span class="text-red-400">*</span>
                </label>
                <input type="text"
                    name="title"
                    value="{{ old('title', $doc->title ?? '') }}"
                    placeholder="Contoh: Setup Environment, Bug Fix Login, dll."
                    required
                    class="w-full border border-gray-200 rounded px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition placeholder-gray-400">
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Type --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Tipe <span class="text-red-400">*</span>
                </label>
                <select name="type"
                    class="w-full border border-gray-200 rounded px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition bg-white">
                    @foreach([
                        'setup'         => 'Setup',
                        'learning_note' => 'Learning Note',
                        'decision'      => 'Decision',
                        'bug_fix'       => 'Bug Fix',
                        'general'       => 'General',
                    ] as $value => $label)
                        <option value="{{ $value }}" {{ old('type', $doc->type ?? 'general') === $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('type')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Content --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Konten <span class="text-red-400">*</span>
                </label>
                <p class="text-xs text-gray-400 mb-2">Mendukung format Markdown (bold, italic, code block, heading, dll.)</p>
                <textarea name="content"
                    rows="12"
                    required
                    placeholder="# Judul Catatan&#10;&#10;Tulis konten dokumentasi di sini...&#10;&#10;## Contoh Sub Heading&#10;- Poin pertama&#10;- Poin kedua&#10;&#10;```php&#10;// Contoh kode&#10;```"
                    class="w-full border border-gray-200 rounded px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition font-mono resize-y placeholder-gray-400">{{ old('content', $doc->content ?? '') }}</textarea>
                @error('content')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <hr class="border-gray-100">

            {{-- Upload Gambar Baru --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Upload Gambar
                    <span class="text-gray-400 font-normal">(opsional, bisa lebih dari 1)</span>
                </label>

                {{-- Drop zone area --}}
                <label for="docImages"
                    class="flex flex-col items-center justify-center w-full border-2 border-dashed border-gray-200 rounded-lg py-8 px-4 cursor-pointer hover:border-indigo-400 hover:bg-indigo-50/30 transition group">
                    <svg class="w-8 h-8 text-gray-300 group-hover:text-indigo-400 transition mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    <p class="text-sm text-gray-500 group-hover:text-indigo-600 transition font-medium">Klik untuk pilih gambar</p>
                    <p class="text-xs text-gray-400 mt-1">PNG, JPG, WEBP — maks. 2MB per file</p>
                    <input id="docImages" type="file" name="images[]" multiple accept="image/*" class="hidden" onchange="previewDocImages(this)">
                </label>
                @error('images.*')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror

                {{-- Preview gambar yang akan diupload --}}
                <div id="newImagePreview" class="flex flex-wrap gap-2 mt-3 empty:hidden"></div>
            </div>

            {{-- Gambar Tersimpan (edit mode) --}}
            @if(isset($doc) && $doc->images && count($doc->images))
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        Gambar Tersimpan
                        <span class="text-gray-400 font-normal">(centang untuk menghapus)</span>
                    </label>
                    <div class="flex flex-wrap gap-3">
                        @foreach($doc->images as $image)
                            <div class="relative group/del">
                                <img src="{{ Storage::url($image) }}" alt=""
                                    class="w-28 h-20 object-cover rounded border border-gray-200 transition group-hover/del:opacity-60">
                                <label class="absolute inset-0 flex items-center justify-center cursor-pointer opacity-0 group-hover/del:opacity-100 transition">
                                    <input type="checkbox" name="delete_images[]" value="{{ $image }}" class="hidden peer">
                                    <span class="peer-checked:bg-red-600 peer-checked:border-red-600 peer-checked:text-white flex items-center gap-1 bg-white/90 border border-gray-300 text-gray-700 text-xs font-semibold px-2 py-1 rounded transition">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Hapus
                                    </span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

        {{-- Submit --}}
        <div class="flex items-center gap-3 mt-6">
            <button type="submit"
                class="bg-indigo-600 text-white px-6 py-2.5 text-sm font-semibold rounded hover:bg-indigo-700 transition">
                {{ isset($doc) ? 'Update Doc' : 'Simpan Doc' }}
            </button>
            <a href="{{ route('dashboard.projects.docs.index', $project) }}"
                class="px-6 py-2.5 text-sm font-semibold rounded text-gray-600 hover:bg-gray-100 transition">
                Batal
            </a>
        </div>
    </form>

@endsection

@push('scripts')
<script>
    function previewDocImages(input) {
        const container = document.getElementById('newImagePreview');
        container.innerHTML = '';

        if (!input.files || !input.files.length) return;

        Array.from(input.files).forEach(function (file) {
            if (!file.type.startsWith('image/')) return;

            const reader = new FileReader();
            reader.onload = function (e) {
                const wrapper = document.createElement('div');
                wrapper.className = 'relative group/preview';

                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'w-24 h-16 object-cover rounded border border-indigo-200';
                img.alt = file.name;

                const label = document.createElement('p');
                label.className = 'text-[10px] text-gray-400 mt-1 truncate max-w-[96px]';
                label.textContent = file.name;

                wrapper.appendChild(img);
                wrapper.appendChild(label);
                container.appendChild(wrapper);
            };
            reader.readAsDataURL(file);
        });
    }
</script>
@endpush