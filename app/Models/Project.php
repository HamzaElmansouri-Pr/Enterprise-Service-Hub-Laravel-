<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'image',
        'gallery',
        'client',
        'category',
        'project_date',
        'project_url',
        'technologies',
        'challenge',
        'solution',
        'result',
        'is_featured',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'gallery' => 'array',
        'technologies' => 'array',
        'project_date' => 'date',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Scope for active projects
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for featured projects
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for ordered projects
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at', 'desc');
    }

    /**
     * Scope for projects by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}