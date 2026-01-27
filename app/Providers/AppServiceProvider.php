<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
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
        //
    }
}
