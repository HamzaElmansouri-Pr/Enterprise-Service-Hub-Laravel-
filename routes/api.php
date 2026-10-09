<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\HomeController;
use App\Http\Controllers\Api\V1\AboutController;
use App\Http\Controllers\Api\V1\ServiceController;
use App\Http\Controllers\Api\V1\ProjectController;
use App\Http\Controllers\Api\V1\BlogController;
use App\Http\Controllers\Api\V1\ContactController;
use App\Http\Controllers\Api\V1\CommentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Public API endpoints consumed by the Next.js frontend.
| All routes are prefixed with /api/v1/
|
*/

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

Route::get('/health', function () {
    try {
        DB::connection()->getPdo();
        $dbStatus = 'connected';
    } catch (\Exception $e) {
        $dbStatus = 'disconnected';
    }

    try {
        Cache::store()->has('health-check');
        $cacheStatus = 'connected';
    } catch (\Exception $e) {
        $cacheStatus = 'disconnected';
    }

    $status = ($dbStatus === 'connected' && $cacheStatus === 'connected') ? 200 : 503;

    return response()->json([
        'status' => $status === 200 ? 'healthy' : 'unhealthy',
        'database' => $dbStatus,
        'cache' => $cacheStatus,
        'timestamp' => now()->toIso8601String(),
    ], $status);
});

Route::prefix('v1')->name('api.v1.')->group(function () {

    // Cached Read-Only Routes (30 minutes max age)
    Route::middleware('cache.headers:public;max_age=1800;etag')->group(function () {
        // Homepage — aggregated data
        Route::get('home', HomeController::class)->name('home');

        // Global Search
        Route::get('search', [\App\Http\Controllers\Api\V1\SearchController::class, 'index'])
            ->name('search')
            ->middleware('throttle:30,1');

        // Global Settings
        Route::get('global', [\App\Http\Controllers\Api\V1\GlobalController::class, 'index'])->name('global');

        // About page
        Route::get('about', AboutController::class)->name('about');

        // Services
        Route::get('services', [ServiceController::class, 'index'])->name('services.index');
        Route::get('services/{slug}', [ServiceController::class, 'show'])->name('services.show');

        // Projects
        Route::get('projects', [ProjectController::class, 'index'])->name('projects.index');
        Route::get('projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');

        // Blog
        Route::get('blogs', [BlogController::class, 'index'])->name('blogs.index');
        Route::get('blogs/{slug}', [BlogController::class, 'show'])->name('blogs.show');
        Route::get('blogs/{slug}/comments', [CommentController::class, 'index'])->name('blogs.comments.index');

        // Contact info
        Route::get('contact-info', [ContactController::class, 'index'])->name('contact.info');
    });

    // Uncached Mutation Routes
    Route::post('search/semantic', [\App\Http\Controllers\Api\V1\SearchController::class, 'semantic'])
        ->name('search.semantic')
        ->middleware('throttle:10,1');

    Route::post('contact', [ContactController::class, 'submit'])
        ->name('contact.submit')
        ->middleware('throttle:form-submissions');
        
    Route::post('tc-request', [ContactController::class, 'tcRequestSubmit'])
        ->name('tc-request.submit')
        ->middleware('throttle:form-submissions');
        
    Route::post('blogs/{slug}/comments', [CommentController::class, 'store'])
        ->name('blogs.comments.store')
        ->middleware('throttle:form-submissions');
        
    Route::post('subscribe', [\App\Http\Controllers\Api\V1\SubscriberController::class, 'subscribe'])
        ->name('subscribe')
        ->middleware('throttle:form-submissions');
        
    Route::post('chat', [\App\Http\Controllers\Api\V1\ChatbotController::class, 'chat'])
        ->name('chat')
        ->middleware('throttle:60,1'); // Limit to 60 requests per minute per IP
});
