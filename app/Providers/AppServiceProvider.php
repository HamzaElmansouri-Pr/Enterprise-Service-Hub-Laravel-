<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Section;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \App\Models\Project::observe(\App\Observers\ProjectObserver::class);
        \App\Models\Service::observe(\App\Observers\ServiceObserver::class);

        // Explicit Policy Mapping for Content Models
        \Illuminate\Support\Facades\Gate::policy(\App\Models\Project::class, \App\Policies\ContentPolicy::class);
        \Illuminate\Support\Facades\Gate::policy(\App\Models\Service::class, \App\Policies\ContentPolicy::class);
        \Illuminate\Support\Facades\Gate::policy(\App\Models\Blog::class, \App\Policies\ContentPolicy::class);
        \Illuminate\Support\Facades\Gate::policy(\App\Models\Slider::class, \App\Policies\ContentPolicy::class);
        \Illuminate\Support\Facades\Gate::policy(\App\Models\Review::class, \App\Policies\ContentPolicy::class);

        RateLimiter::for('form-submissions', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        View::composer('*', function ($view) {
            $siteInfo = cache()->remember('site_info', 3600, function () {
                $section = Section::where('type', 'site-info')->with('contentBlocks')->first();
                if (!$section) return [];
                return $section->contentBlocks->pluck('content', 'key')->toArray();
            });
            $view->with('site_info', $siteInfo);
        });
    }
}
