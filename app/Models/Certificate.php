<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [
        'name',
        'issuer',
        'issued_date',
        'expired_date',
        'credential_url',
        'image',
        'is_featured',
    ];

    protected $casts = [
        'issued_date' => 'date',
        'expired_date' => 'date',
        'is_featured' => 'boolean',
    ];
}