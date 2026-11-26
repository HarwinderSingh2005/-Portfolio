<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title', 'category', 'summary', 'description', 'features', 'technologies',
        'image', 'repo_url', 'live_url', 'status_note', 'sort_order',
    ];

    protected $casts = [
        'features' => 'array',
        'technologies' => 'array',
    ];
}
