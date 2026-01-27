<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'client_position',
        'client_company',
        'client_image',
        'review_text',
        'rating',
        'project_type',
        'is_featured',
        'is_active',
        'order_index',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'rating' => 'integer',
        'order_index' => 'integer',
    ];
}
