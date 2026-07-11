<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\LogsActivity;
use Spatie\Translatable\HasTranslations;
use Laravel\Scout\Searchable;

class Project extends Model
{
    use LogsActivity, HasFactory, SoftDeletes, HasTranslations, Searchable;

    public $translatable = ['title', 'description', 'meta_title', 'meta_description'];

    protected $attributes = [
        'is_active' => true,
    ];

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
        'meta_title',
        'meta_description',
        'og_image',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'completion_date' => 'date',
    ];

    /**
     * Determine if the model should be searchable.
     */
    public function shouldBeSearchable(): bool
    {
        return $this->is_active;
    }

    /**
     * Get the indexable data array for the model.
     */
    public function toSearchableArray(): array
    {
        $array = [
            'id' => $this->id,
            'title' => $this->getTranslations('title'),
            'url_slug' => $this->slug,
            'image' => $this->image,
            'category' => $this->category,
            'client' => $this->client,
            'type' => 'project',
        ];

        // Strip HTML tags from description for clean indexing
        $descTranslations = $this->getTranslations('description');
        foreach ($descTranslations as $locale => $content) {
            $descTranslations[$locale] = strip_tags($content);
        }
        $array['content'] = $descTranslations;
        $array['excerpt'] = $descTranslations; // Using description as excerpt since no separate excerpt

        // Generate vector embeddings for semantic search
        $textToEmbed = strip_tags($this->title . ' ' . $this->description . ' ' . $this->client . ' ' . $this->category);
        try {
            $array['_vectors'] = app(\App\Services\AI\AIService::class)->embed($textToEmbed);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to generate embedding for Project ' . $this->id . ': ' . $e->getMessage());
        }

        return $array;
    }
}
