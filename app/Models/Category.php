<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Traits\LogsActivity;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory, LogsActivity, HasTranslations;

    public $translatable = ['name', 'description'];

    protected $attributes = [
        'is_active' => true,
    ];

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
        'order_index',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order_index' => 'integer',
    ];

    /**
     * Get the projects associated with the category.
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'category_project');
    }

    /**
     * Get the blogs associated with the category.
     */
    public function blogs(): BelongsToMany
    {
        return $this->belongsToMany(Blog::class, 'category_blog');
    }
}
