<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimelineEntry extends Model
{
    protected $fillable = ['type', 'title', 'subtitle', 'period_label', 'details', 'sort_order'];

    protected $casts = [
        'details' => 'array',
    ];
}
