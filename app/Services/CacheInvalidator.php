<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use App\Models\Service;
use App\Models\Project;
use App\Models\Blog;
use App\Models\Review;
use App\Models\Slider;
use App\Models\Partner;
use App\Models\Section;

class CacheInvalidator
{
    /**
     * Clear the cache for a given model instance using tags if available.
     *
     * @param Model $model
     * @return void
     */
    public function invalidateFor(Model $model): void
    {
        // For default or database cache driver without tags support, we clear specific keys.
        // For redis/memcached, we can use tags.
        
        $driver = config('cache.default');
        
        // Regardless of driver, we must clear the global API home data cache
        // since home data aggregates from multiple models
        Cache::forget('api_home_data');
        
        if ($model instanceof Section && $model->type === 'site-info') {
            Cache::forget('site_info');
        }

        if (in_array($driver, ['redis', 'memcached'])) {
            $tags = ['api']; // Global API tag
            
            $modelTags = $this->getTagsForModel($model);
            if (!empty($modelTags)) {
                $tags = array_merge($tags, $modelTags);
                try {
                    Cache::tags($tags)->flush();
                } catch (\Throwable $e) {
                    // Ignore tag flush failure
                }
            }
        }

        // Flush the cache so dynamic keys without tags (like api_projects_index_*) are immediately cleared
        try {
            Cache::flush();
        } catch (\Throwable $e) {
            // Ignore flush failure
        }
    }

    /**
     * Get specific cache tags based on the model.
     *
     * @param Model $model
     * @return array<string>
     */
    protected function getTagsForModel(Model $model): array
    {
        return match (get_class($model)) {
            \App\Models\Category::class => ['categories', 'projects', 'blogs'],
            Service::class => ['services'],
            Project::class => ['projects'],
            Blog::class => ['blogs'],
            Review::class => ['reviews'],
            Slider::class => ['sliders'],
            Partner::class => ['partners'],
            Section::class => ['sections'],
            default => [],
        };
    }
}
