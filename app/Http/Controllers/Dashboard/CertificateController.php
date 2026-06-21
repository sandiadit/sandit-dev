<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Repositories\Contracts\CertificateRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    public function __construct(
        private CertificateRepositoryInterface $certificateRepository
    ) {
    }

    public function index()
    {
        $certificates = $this->certificateRepository->getAll();
        return view('dashboard.certificates.index', compact('certificates'));
    }

    public function create()
    {
        return view('dashboard.certificates.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'issuer' => 'required|string|max:255',
            'issued_date' => 'required|date',
            'expired_date' => 'nullable|date|after:issued_date',
            'credential_url' => 'nullable|url',
            'image' => 'nullable|mimes:jpg,jpeg,png,webp|max:2048',
            'is_featured' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('certificates', 'public');
        }

        $validated['is_featured'] = $request->boolean('is_featured');

        $this->certificateRepository->create($validated);

        return redirect()->route('dashboard.certificates.index')
            ->with('success', 'Certificate berhasil ditambahkan.');
    }

    public function edit(Certificate $certificate)
    {
        return view('dashboard.certificates.form', compact('certificate'));
    }

    public function update(Request $request, Certificate $certificate)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'issuer' => 'required|string|max:255',
            'issued_date' => 'required|date',
            'expired_date' => 'nullable|date|after:issued_date',
            'credential_url' => 'nullable|url',
            'image' => 'nullable|mimes:jpg,jpeg,png,webp|max:2048',
            'is_featured' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($certificate->image) {
                Storage::disk('public')->delete($certificate->image);
            }
            $validated['image'] = $request->file('image')->store('certificates', 'public');
        }

        $validated['is_featured'] = $request->boolean('is_featured');

        $this->certificateRepository->update($certificate, $validated);

        return redirect()->route('dashboard.certificates.index')
            ->with('success', 'Certificate berhasil diupdate.');
    }

    public function destroy(Certificate $certificate)
    {
        if ($certificate->image) {
            Storage::disk('public')->delete($certificate->image);
        }

        $this->certificateRepository->delete($certificate);

        return redirect()->route('dashboard.certificates.index')
            ->with('success', 'Certificate berhasil dihapus.');
    }
}