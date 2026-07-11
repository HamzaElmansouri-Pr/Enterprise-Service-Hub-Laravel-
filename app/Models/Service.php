<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\LogsActivity;
use Spatie\Translatable\HasTranslations;
use Laravel\Scout\Searchable;

class Service extends Model
{
    use LogsActivity, HasFactory, HasTranslations, SoftDeletes, Searchable;

    public $translatable = ['title', 'subtitle', 'description', 'meta_title', 'meta_description'];

    protected $attributes = [
        'is_active' => true,
    ];

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
            'subtitle' => $this->getTranslations('subtitle'),
            'url_slug' => $this->slug,
            'image' => $this->image,
            'icon' => $this->icon,
            'type' => 'service',
        ];

        // Strip HTML tags from description for clean indexing
        $descTranslations = $this->getTranslations('description');
        foreach ($descTranslations as $locale => $content) {
            $descTranslations[$locale] = strip_tags($content);
        }
        $array['content'] = $descTranslations;
        $array['excerpt'] = $array['subtitle'];

        // Generate vector embeddings for semantic search
        $textToEmbed = strip_tags($this->title . ' ' . $this->subtitle . ' ' . $this->description);
        try {
            $array['_vectors'] = app(\App\Services\AI\AIService::class)->embed($textToEmbed);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to generate embedding for Service ' . $this->id . ': ' . $e->getMessage());
        }

        return $array;
    }
}
