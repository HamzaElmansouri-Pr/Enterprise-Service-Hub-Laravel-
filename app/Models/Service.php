<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'description',
        'icon',
        'image',
        'order_index',
        'is_active',
        'meta_title',
        'meta_description',
        'og_image',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
