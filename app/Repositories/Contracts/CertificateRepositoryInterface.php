<?php

namespace App\Repositories\Contracts;

use App\Models\Certificate;

interface CertificateRepositoryInterface
{
    public function getAll();
    public function getFeatured();
    public function create(array $data): Certificate;
    public function update(Certificate $certificate, array $data): Certificate;
    public function delete(Certificate $certificate): void;
}