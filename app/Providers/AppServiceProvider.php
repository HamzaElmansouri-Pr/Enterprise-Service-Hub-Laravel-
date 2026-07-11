<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Section;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Load custom helpers
        require_once app_path('Helpers/helpers.php');

        // Phase 1 Cleanup: Legacy bindings removed.
        
        $this->app->bind(
            \App\Repositories\Interfaces\ContactRepositoryInterface::class,
            \App\Repositories\ContactRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\TcRequestRepositoryInterface::class,
            \App\Repositories\TcRequestRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\UserRepositoryInterface::class,
            \App\Repositories\UserRepository::class
        );
        // ContentRepository might be needed if adapted, but leaving it bound if it exists.
        if (class_exists(\App\Repositories\ContentRepository::class)) {
             $this->app->bind(
                \App\Repositories\Interfaces\ContentRepositoryInterface::class,
                \App\Repositories\ContentRepository::class
            );
        }

        $this->app->bind(
            \App\Repositories\Interfaces\ServiceRepositoryInterface::class,
            \App\Repositories\ServiceRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\ProjectRepositoryInterface::class,
            \App\Repositories\ProjectRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\BlogRepositoryInterface::class,
            \App\Repositories\BlogRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\ReviewRepositoryInterface::class,
            \App\Repositories\ReviewRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\SliderRepositoryInterface::class,
            \App\Repositories\SliderRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\PartnerRepositoryInterface::class,
            \App\Repositories\PartnerRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\SectionRepositoryInterface::class,
            \App\Repositories\SectionRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Prevent lazy loading in non-production environments to catch N+1 queries
        Model::preventLazyLoading(!app()->isProduction());

        // Explicit Policy Mapping
        \Illuminate\Support\Facades\Gate::policy(\App\Models\Project::class, \App\Policies\ProjectPolicy::class);
        \Illuminate\Support\Facades\Gate::policy(\App\Models\Service::class, \App\Policies\ServicePolicy::class);
        \Illuminate\Support\Facades\Gate::policy(\App\Models\Blog::class, \App\Policies\BlogPolicy::class);
        \Illuminate\Support\Facades\Gate::policy(\App\Models\Slider::class, \App\Policies\SliderPolicy::class);
        \Illuminate\Support\Facades\Gate::policy(\App\Models\Review::class, \App\Policies\ReviewPolicy::class);
        \Illuminate\Support\Facades\Gate::policy(\App\Models\Section::class, \App\Policies\ContentPolicy::class);
        \Illuminate\Support\Facades\Gate::policy(\App\Models\Partner::class, \App\Policies\ContentPolicy::class);
        \Illuminate\Support\Facades\Gate::policy(\App\Models\Contact::class, \App\Policies\ContactPolicy::class);

        $contentModels = [
            \App\Models\Project::class,
            \App\Models\Service::class,
            \App\Models\Blog::class,
            \App\Models\Slider::class,
            \App\Models\Review::class,
            \App\Models\Section::class,
            \App\Models\Partner::class,
        ];

        $clearTargetedCache = function ($instance) {
            $invalidator = app(\App\Services\CacheInvalidator::class);
            $invalidator->invalidateFor($instance);
        };

        foreach ($contentModels as $model) {
            $model::saved($clearTargetedCache);
            $model::deleted($clearTargetedCache);
        }

        RateLimiter::for('form-submissions', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        View::composer(['layouts.app', 'layouts.admin', 'layouts.guest', 'partials.frontend-header', 'partials.frontend-footer'], function ($view) {
            $siteInfo = cache()->remember('site_info', 3600, function () {
                $section = Section::where('type', 'site-info')->with('contentBlocks')->first();
                if (!$section) return [];
                return $section->contentBlocks->pluck('content', 'key')->toArray();
            });
            $view->with('site_info', $siteInfo);
        });
    }
}
