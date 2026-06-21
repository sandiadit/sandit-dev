@extends('layouts.dashboard')

@section('title', isset($certificate) ? 'Edit Certificate' : 'Tambah Certificate')

@section('content')

    <div class="max-w-2xl">

        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">
                {{ isset($certificate) ? 'Edit Certificate' : 'Tambah Certificate' }}
            </h1>
            <p class="text-gray-500 text-sm mt-1">
                {{ isset($certificate) ? 'Update informasi certificate.' : 'Tambah certificate atau pencapaian baru.' }}
            </p>
        </div>

        <form action="{{ isset($certificate)
        ? route('dashboard.certificates.update', $certificate)
        : route('dashboard.certificates.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white border border-gray-200 rounded p-8 space-y-6">
            @csrf
            @if(isset($certificate)) @method('PUT') @endif

            {{-- Name --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Certificate <span
                        class="text-red-400">*</span></label>
                <input type="text" name="name" value="{{ old('name', $certificate->name ?? '') }}"
                    placeholder="misal: AWS Certified Developer"
                    class="w-full border border-gray-200 rounded px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Issuer --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Issuer <span
                        class="text-red-400">*</span></label>
                <input type="text" name="issuer" value="{{ old('issuer', $certificate->issuer ?? '') }}"
                    placeholder="misal: Amazon Web Services, Dicoding, Google"
                    class="w-full border border-gray-200 rounded px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                @error('issuer') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Dates --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Issued Date <span
                            class="text-red-400">*</span></label>
                    <input type="date" name="issued_date"
                        value="{{ old('issued_date', isset($certificate) ? $certificate->issued_date->format('Y-m-d') : '') }}"
                        class="w-full border border-gray-200 rounded px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                    @error('issued_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Expired Date <span class="text-gray-400 font-normal">(kosong = no expiry)</span>
                    </label>
                    <input type="date" name="expired_date"
                        value="{{ old('expired_date', isset($certificate) && $certificate->expired_date ? $certificate->expired_date->format('Y-m-d') : '') }}"
                        class="w-full border border-gray-200 rounded px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                    @error('expired_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Credential URL --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Credential URL <span class="text-gray-400 font-normal">(opsional)</span>
                </label>
                <input type="url" name="credential_url"
                    value="{{ old('credential_url', $certificate->credential_url ?? '') }}" placeholder="https://..."
                    class="w-full border border-gray-200 rounded px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                @error('credential_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Image --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Foto Certificate <span class="text-gray-400 font-normal">(opsional)</span>
                </label>
                @if(isset($certificate) && $certificate->image)
                    <div class="flex items-center gap-4 mb-3">
                        <img src="{{ Storage::url($certificate->image) }}" alt=""
                            class="w-32 h-20 object-cover rounded border border-gray-200">
                        <p class="text-xs text-gray-400">Upload baru untuk mengganti foto</p>
                    </div>
                @endif
                <input type="file" name="image" accept="image/*"
                    class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:border file:border-gray-300 file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100 file:transition">
                @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Is Featured --}}
            <div class="flex items-center gap-3 p-4 bg-amber-50 border border-amber-100 rounded">
                <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $certificate->is_featured ?? false) ? 'checked' : '' }} class="w-4 h-4 accent-indigo-600">
                <div>
                    <label for="is_featured" class="text-sm font-semibold text-gray-700 cursor-pointer">
                        Tampilkan di Landing Page
                    </label>
                    <p class="text-xs text-gray-400 mt-0.5">Certificate ini akan muncul di section certificates homepage.
                    </p>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex gap-3 pt-2">
                <button type="submit"
                    class="bg-indigo-600 text-white px-6 py-2.5 text-sm font-semibold rounded hover:bg-indigo-700 transition">
                    {{ isset($certificate) ? 'Update Certificate' : 'Simpan Certificate' }}
                </button>
                <a href="{{ route('dashboard.certificates.index') }}"
                    class="px-6 py-2.5 text-sm font-semibold border border-gray-200 rounded text-gray-600 hover:bg-gray-50 transition">
                    Batal
                </a>
            </div>

        </form>
    </div>

@endsection