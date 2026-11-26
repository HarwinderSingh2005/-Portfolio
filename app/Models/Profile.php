<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'full_name', 'primary_title', 'hero_kicker', 'hero_headline', 'hero_subtitle',
        'hero_description', 'rotating_roles', 'location', 'email', 'phone', 'linkedin',
        'github', 'about_paragraphs', 'portrait_image',
    ];

    protected $casts = [
        'rotating_roles' => 'array',
        'about_paragraphs' => 'array',
    ];
}
