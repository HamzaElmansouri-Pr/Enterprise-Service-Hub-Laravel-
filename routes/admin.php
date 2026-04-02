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

// Admin Authentication Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Redirect admin login to main auth login
    Route::get('/login', function () {
        return redirect()->route('login');
    })->name('login');
    
    // Protected admin routes
    Route::middleware(['auth', 'admin'])->group(function () {
        // Dashboard
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('search', [SearchController::class, 'query'])->name('search.query');
        
        // Modules
        Route::resource('services', ServiceController::class);
        Route::resource('projects', ProjectController::class);
        Route::resource('reviews', ReviewController::class);
        Route::resource('blogs', BlogController::class);
        Route::patch('sliders/{slider}/toggle-active', [SliderController::class, 'toggleActive'])->name('sliders.toggle-active');
        Route::resource('sliders', SliderController::class);
        Route::resource('partners', PartnerController::class);
        Route::patch('contacts/mark-all-read', [ContactController::class, 'markAllAsRead'])->name('contacts.mark-all-read');
        Route::patch('contacts/{contact}/mark-read', [ContactController::class, 'markAsRead'])->name('contacts.mark-read');
        Route::patch('contacts/{contact}/mark-unread', [ContactController::class, 'markAsUnread'])->name('contacts.mark-unread');
        Route::resource('contacts', ContactController::class)->only(['index', 'show', 'destroy']);
        
        Route::patch('tc-requests/mark-all-read', [TcRequestController::class, 'markAllAsRead'])->name('tc-requests.mark-all-read');
        Route::patch('tc-requests/{tc_request}/mark-read', [TcRequestController::class, 'markAsRead'])->name('tc-requests.mark-read');
        Route::patch('tc-requests/{tc_request}/mark-unread', [TcRequestController::class, 'markAsUnread'])->name('tc-requests.mark-unread');
        Route::patch('tc-requests/{tc_request}/update-status', [TcRequestController::class, 'updateStatus'])->name('tc-requests.update-status');
        Route::resource('tc-requests', TcRequestController::class)->only(['index', 'show', 'destroy']);
        
        Route::patch('users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');
        Route::resource('users', UserController::class);

        // Content
        Route::get('content', [ContentController::class, 'index'])->name('content.index');
        Route::get('content/{type}/edit', [ContentController::class, 'edit'])->name('content.edit');
        Route::put('content/{type}', [ContentController::class, 'update'])->name('content.update');
        Route::post('content/{type}/item/{key}/{index}', [ContentController::class, 'updateItem'])->name('content.update-item');
        Route::delete('content/{type}/image/{key}', [ContentController::class, 'destroyImage'])->name('content.destroy-image');

        // Settings
        Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::get('settings/profile', [SettingsController::class, 'editProfile'])->name('settings.edit-profile');
        Route::put('settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.update-profile');
        Route::get('settings/password', [SettingsController::class, 'editPassword'])->name('settings.edit-password');
        Route::put('settings/password', [SettingsController::class, 'updatePassword'])->name('settings.update-password');
        Route::delete('settings/profile/image', [SettingsController::class, 'deleteImage'])->name('settings.delete-image');
    });
});
