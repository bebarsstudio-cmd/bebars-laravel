<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title', 'description', 'image', 'github_url', 'live_url', 'technologies', 'status', 'order'
    ];

    protected $casts = [
        'technologies' => 'array',
    ];
}