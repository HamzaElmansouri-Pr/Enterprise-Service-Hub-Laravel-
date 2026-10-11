<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;
use Laravel\Scout\Searchable;

class Blog extends Model
{
    use LogsActivity;

    use HasFactory, HasTranslations, SoftDeletes, Searchable;

    public $translatable = ['title', 'excerpt', 'content', 'meta_title', 'meta_description'];

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'image',
        'author_id',
        'published_at',
        'is_active',
        'category',
        'meta_title',
        'meta_description',
        'og_image',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get the categories associated with the blog post.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_blog');
    }

    /**
     * Scope a query to only include active blog posts.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->whereNotNull('published_at');
    }

    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function approvedComments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class)->where('status', 'approved');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Determine if the model should be searchable.
     */
    public function shouldBeSearchable(): bool
    {
        return $this->is_active && $this->published_at !== null;
    }

    /**
     * Get the indexable data array for the model.
     */
    public function toSearchableArray(): array
    {
        $array = [
            'id' => $this->id,
            'title' => $this->getTranslations('title'),
            'excerpt' => $this->getTranslations('excerpt'),
            'category' => $this->category,
            'published_at' => $this->published_at?->timestamp,
            'url_slug' => $this->slug,
            'image' => $this->image,
            'type' => 'blog',
        ];

        // Strip HTML tags from content for clean indexing
        $contentTranslations = $this->getTranslations('content');
        foreach ($contentTranslations as $locale => $content) {
            $contentTranslations[$locale] = strip_tags($content);
        }
        $array['content'] = $contentTranslations;

        // Generate vector embeddings for semantic search
        $textToEmbed = strip_tags($this->title . ' ' . $this->excerpt . ' ' . $this->content);
        try {
            $array['_vectors'] = app(\App\Services\AI\AIService::class)->embed($textToEmbed);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to generate embedding for Blog ' . $this->id . ': ' . $e->getMessage());
        }

        return $array;
    }
}
