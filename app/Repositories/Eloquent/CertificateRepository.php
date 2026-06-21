<?php

namespace App\Repositories\Eloquent;

use App\Models\Certificate;
use App\Repositories\Contracts\CertificateRepositoryInterface;

class CertificateRepository implements CertificateRepositoryInterface
{
    public function getAll()
    {
        return Certificate::latest('issued_date')->get();
    }

    public function getFeatured()
    {
        return Certificate::where('is_featured', true)->latest('issued_date')->get();
    }

    public function create(array $data): Certificate
    {
        return Certificate::create($data);
    }

    public function update(Certificate $certificate, array $data): Certificate
    {
        $certificate->update($data);
        return $certificate;
    }

    public function delete(Certificate $certificate): void
    {
        $certificate->delete();
    }
}