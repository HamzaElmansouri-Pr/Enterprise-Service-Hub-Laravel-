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
                Cache::tags($tags)->flush();
            }
        } else {
            // For file or database drivers, we can't use tags to selectively clear dynamic keys.
            // Flush the entire cache to ensure changes are immediately reflected on the frontend.
            Cache::flush();
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
