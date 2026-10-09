<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\TcRequestController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\SubscriberController;

// Admin Authentication Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Redirect admin login to main auth login
    Route::get('/login', function () {
        return redirect()->route('login');
    })->name('login');
    
    // Protected admin routes
    Route::middleware(['auth', 'verified', 'admin'])->group(function () {
        // Dashboard
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/dashboard/ai-insights', [AdminController::class, 'generateInsights'])->name('dashboard.insights');
        Route::get('search', [SearchController::class, 'query'])->name('search.query');
        Route::post('ai/generate-content', [\App\Http\Controllers\Admin\AIController::class, 'generateContent'])->name('ai.generate');
        Route::post('ai/seo-analyze', [\App\Http\Controllers\Admin\AIController::class, 'analyzeSeo'])->name('ai.seo-analyze');
        Route::post('ai/assistant', [\App\Http\Controllers\Admin\AIController::class, 'assistantRouter'])->name('ai.assistant');
        
        // Modules
        Route::resource('services', ServiceController::class);
        Route::resource('projects', ProjectController::class);
        Route::resource('reviews', ReviewController::class);
        Route::patch('blogs/{blog}/inline-update', [BlogController::class, 'inlineUpdate'])->name('blogs.inline-update');
        Route::post('blogs/bulk-action', [BlogController::class, 'bulkAction'])->name('blogs.bulk-action');
        Route::resource('blogs', BlogController::class);
        
        Route::patch('comments/{comment}/update-status', [\App\Http\Controllers\Admin\CommentController::class, 'updateStatus'])->name('comments.update-status');
        Route::resource('comments', \App\Http\Controllers\Admin\CommentController::class)->only(['index', 'destroy']);
        Route::patch('sliders/{slider}/toggle-active', [SliderController::class, 'toggleActive'])->name('sliders.toggle-active');
        Route::resource('sliders', SliderController::class);
        Route::resource('partners', PartnerController::class);
        Route::get('contacts/export', [ContactController::class, 'export'])->name('contacts.export');
        Route::patch('contacts/mark-all-read', [ContactController::class, 'markAllAsRead'])->name('contacts.mark-all-read');
        Route::patch('contacts/{contact}/mark-read', [ContactController::class, 'markAsRead'])->name('contacts.mark-read');
        Route::patch('contacts/{contact}/mark-unread', [ContactController::class, 'markAsUnread'])->name('contacts.mark-unread');
        Route::post('contacts/{contact}/reply', [ContactController::class, 'reply'])->name('contacts.reply');
        Route::post('contacts/bulk-action', [ContactController::class, 'bulkAction'])->name('contacts.bulk-action');
        Route::resource('contacts', ContactController::class)->only(['index', 'show', 'destroy']);
        
        Route::get('subscribers/export', [SubscriberController::class, 'export'])->name('subscribers.export');
        Route::patch('subscribers/{subscriber}/toggle', [SubscriberController::class, 'toggleStatus'])->name('subscribers.toggle');
        Route::resource('subscribers', SubscriberController::class)->only(['index', 'destroy']);
        
        Route::get('tc-requests/export', [TcRequestController::class, 'export'])->name('tc-requests.export');
        Route::patch('tc-requests/mark-all-read', [TcRequestController::class, 'markAllAsRead'])->name('tc-requests.mark-all-read');
        Route::patch('tc-requests/{tc_request}/mark-read', [TcRequestController::class, 'markAsRead'])->name('tc-requests.mark-read');
        Route::patch('tc-requests/{tc_request}/mark-unread', [TcRequestController::class, 'markAsUnread'])->name('tc-requests.mark-unread');
        Route::patch('tc-requests/{tc_request}/update-status', [TcRequestController::class, 'updateStatus'])->name('tc-requests.update-status');
        Route::patch('tc-requests/{tc_request}/inline-update', [TcRequestController::class, 'inlineUpdate'])->name('tc-requests.inline-update');
        Route::post('tc-requests/bulk-action', [TcRequestController::class, 'bulkAction'])->name('tc-requests.bulk-action');
        Route::resource('tc-requests', TcRequestController::class)->only(['index', 'show', 'destroy']);

        // Trash Routes
        Route::get('trash', [\App\Http\Controllers\Admin\TrashController::class, 'index'])->name('trash.index');
        Route::patch('trash/{type}/{id}/restore', [\App\Http\Controllers\Admin\TrashController::class, 'restore'])->name('trash.restore');
        Route::delete('trash/{type}/{id}/force-delete', [\App\Http\Controllers\Admin\TrashController::class, 'forceDelete'])->name('trash.force-delete');
        
        Route::patch('users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');
        Route::resource('users', UserController::class);

        // Activity Logs
        Route::get('activity-logs/export', [\App\Http\Controllers\Admin\ActivityLogController::class, 'export'])->name('activity-logs.export');
        Route::get('activity-logs', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activity-logs.index');

        // Media
        Route::resource('media', \App\Http\Controllers\Admin\MediaController::class)->only(['index', 'store', 'destroy']);

        // Content
        Route::get('content', [ContentController::class, 'index'])->name('content.index');
        Route::post('content/reorder', [ContentController::class, 'reorder'])->name('content.reorder');
        Route::patch('content/{type}/toggle-active', [ContentController::class, 'toggleActive'])->name('content.toggle-active');
        Route::get('content/{type}/edit', [ContentController::class, 'edit'])->name('content.edit');
        Route::put('content/{type}', [ContentController::class, 'update'])->name('content.update');
        Route::post('content/{type}/item/{key}/{index}', [ContentController::class, 'updateItem'])->name('content.update-item');
        Route::delete('content/{type}/image/{key}', [ContentController::class, 'destroyImage'])->name('content.destroy-image');

        // Pages & SEO
        Route::resource('pages', \App\Http\Controllers\Admin\PageController::class)->only(['index', 'edit', 'update']);

        // Settings
        Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::get('settings/profile', [SettingsController::class, 'editProfile'])->name('settings.edit-profile');
        Route::put('settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.update-profile');
        Route::get('settings/password', [SettingsController::class, 'editPassword'])->name('settings.edit-password');
        Route::put('settings/password', [SettingsController::class, 'updatePassword'])->name('settings.update-password');
        Route::delete('settings/profile/image', [SettingsController::class, 'deleteImage'])->name('settings.delete-image');
        Route::get('settings/2fa', [SettingsController::class, 'twoFactor'])->name('settings.2fa');
        Route::post('settings/theme', [SettingsController::class, 'updateTheme'])->name('settings.theme');
        Route::post('settings/preferences', [SettingsController::class, 'updatePreferences'])->name('settings.preferences');

        // Notifications
        Route::post('notifications/{id}/read', function (Illuminate\Http\Request $request, $id) {
            $notification = $request->user()->notifications()->findOrFail($id);
            $notification->markAsRead();
            return response()->json(['success' => true]);
        })->name('notifications.read');
        
        Route::post('notifications/read-all', function (Illuminate\Http\Request $request) {
            $request->user()->unreadNotifications->markAsRead();
            return redirect()->back();
        })->name('notifications.read-all');
    });
});
