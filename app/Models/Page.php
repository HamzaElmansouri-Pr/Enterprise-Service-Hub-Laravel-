<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'subtitle',
        'description',
        'image',
        'content',
        'meta_data',
        'is_active',
    ];

    protected $casts = [
        'meta_data' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the page by name
     */
    public static function getByName($name)
    {
        return static::where('name', $name)->where('is_active', true)->first();
    }

    /**
     * Scope for active pages
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}