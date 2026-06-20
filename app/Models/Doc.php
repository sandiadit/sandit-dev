<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doc extends Model
{
    protected $fillable = [
        'project_id',
        'title',
        'content',
        'type',
        'images',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}