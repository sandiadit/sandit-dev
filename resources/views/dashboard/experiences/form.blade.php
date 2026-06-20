@extends('layouts.dashboard')

@section('title', isset($experience) ? 'Edit Experience' : 'Tambah Experience')

@section('content')
    <h1 style="margin-bottom:1.5rem">
        {{ isset($experience) ? 'Edit Experience' : 'Tambah Experience' }}
    </h1>

    <form action="{{ isset($experience)
            ? route('dashboard.experiences.update', $experience)
            : route('dashboard.experiences.store') }}"
          method="POST" style="max-width:500px">
        @csrf
        @if(isset($experience)) @method('PUT') @endif

        <div style="margin-bottom:1rem">
            <label>Title</label><br>
            <input type="text" name="title"
                   value="{{ old('title', $experience->title ?? '') }}"
                   style="width:100%; padding:0.5rem; margin-top:0.25rem">
            @error('title') <small style="color:red">{{ $message }}</small> @enderror
        </div>

        <div style="margin-bottom:1rem">
            <label>Company</label><br>
            <input type="text" name="company"
                   value="{{ old('company', $experience->company ?? '') }}"
                   style="width:100%; padding:0.5rem; margin-top:0.25rem">
            @error('company') <small style="color:red">{{ $message }}</small> @enderror
        </div>

        <div style="margin-bottom:1rem">
            <label>Description</label><br>
            <textarea name="description" rows="3"
                      style="width:100%; padding:0.5rem; margin-top:0.25rem">{{ old('description', $experience->description ?? '') }}</textarea>
        </div>

        <div style="display:flex; gap:1rem; margin-bottom:1.5rem">
            <div style="flex:1">
                <label>Start Date</label><br>
                <input type="date" name="start_date"
                       value="{{ old('start_date', isset($experience) ? $experience->start_date->format('Y-m-d') : '') }}"
                       style="width:100%; padding:0.5rem; margin-top:0.25rem">
                @error('start_date') <small style="color:red">{{ $message }}</small> @enderror
            </div>
            <div style="flex:1">
                <label>End Date <span style="color:#aaa">(kosong = Present)</span></label><br>
                <input type="date" name="end_date"
                       value="{{ old('end_date', isset($experience) && $experience->end_date ? $experience->end_date->format('Y-m-d') : '') }}"
                       style="width:100%; padding:0.5rem; margin-top:0.25rem">
                @error('end_date') <small style="color:red">{{ $message }}</small> @enderror
            </div>
        </div>

        <div style="display:flex; gap:1rem">
            <button type="submit">{{ isset($experience) ? 'Update' : 'Simpan' }}</button>
            <a href="{{ route('dashboard.experiences.index') }}">Batal</a>
        </div>
    </form>
@endsection