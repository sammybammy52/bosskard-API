<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'services' => 'array',
        'blogs' => 'array',
        'testimonials' => 'array',
    ];
}
