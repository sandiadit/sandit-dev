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
          method="POST" enctype="multipart/form-data" style="max-width:600px">
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
        </div>

        <div style="margin-bottom:1rem">
            <label>Content</label><br>
            <textarea name="content" rows="10"
                      style="width:100%; padding:0.5rem; margin-top:0.25rem; font-family:monospace">{{ old('content', $doc->content ?? '') }}</textarea>
            @error('content') <small style="color:red">{{ $message }}</small> @enderror
        </div>

        {{-- Upload gambar baru --}}
        <div style="margin-bottom:1rem">
            <label>Upload Gambar <span style="color:#aaa">(bisa lebih dari 1)</span></label><br>
            <input type="file" name="images[]" multiple accept="image/*"
                   style="margin-top:0.25rem">
            @error('images.*') <small style="color:red">{{ $message }}</small> @enderror
        </div>

        {{-- Gambar yang sudah ada (edit mode) --}}
        @if(isset($doc) && $doc->images)
            <div style="margin-bottom:1.5rem">
                <label>Gambar Tersimpan</label>
                <div style="display:flex; flex-wrap:wrap; gap:0.75rem; margin-top:0.5rem">
                    @foreach($doc->images as $image)
                        <div style="text-align:center">
                            <img src="{{ Storage::url($image) }}" alt=""
                                 style="width:120px; height:80px; object-fit:cover; border:1px solid #ccc; border-radius:4px">
                            <div style="margin-top:0.25rem">
                                <label style="font-size:0.75rem; color:red">
                                    <input type="checkbox" name="delete_images[]" value="{{ $image }}">
                                    Hapus
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div style="display:flex; gap:1rem">
            <button type="submit">{{ isset($doc) ? 'Update' : 'Simpan' }}</button>
            <a href="{{ route('dashboard.projects.docs.index', $project) }}">Batal</a>
        </div>
    </form>
@endsection