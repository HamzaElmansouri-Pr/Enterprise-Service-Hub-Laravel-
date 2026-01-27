<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'client',
        'completion_date',
        'category',
        'image',
        'is_active',
        'order_index',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'completion_date' => 'date',
    ];
}
