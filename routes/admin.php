<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\TcRequestController;
use App\Http\Controllers\Admin\UserController;

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
        
        // Content Management
        Route::prefix('content')->name('content.')->group(function () {
            Route::get('/', [ContentController::class, 'index'])->name('index');
            Route::get('/{contentType}/edit', [ContentController::class, 'edit'])->name('edit');
            Route::put('/{contentType}', [ContentController::class, 'update'])->name('update');
        });
        
        // Settings Management
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('index');
            Route::get('/profile/edit', [\App\Http\Controllers\Admin\SettingsController::class, 'editProfile'])->name('edit-profile');
            Route::put('/profile', [\App\Http\Controllers\Admin\SettingsController::class, 'updateProfile'])->name('update-profile');
            Route::get('/password/edit', [\App\Http\Controllers\Admin\SettingsController::class, 'editPassword'])->name('edit-password');
            Route::put('/password', [\App\Http\Controllers\Admin\SettingsController::class, 'updatePassword'])->name('update-password');
            Route::delete('/image', [\App\Http\Controllers\Admin\SettingsController::class, 'deleteImage'])->name('delete-image');
        });
        
        // Services Management
        Route::resource('services', ServiceController::class);
        Route::patch('services/{service}/toggle-status', [ServiceController::class, 'toggleStatus'])->name('services.toggle-status');
        Route::patch('services/{service}/toggle-featured', [ServiceController::class, 'toggleFeatured'])->name('services.toggle-featured');
        
        // Projects Management
        Route::resource('projects', ProjectController::class);
        Route::patch('projects/{project}/toggle-status', [ProjectController::class, 'toggleStatus'])->name('projects.toggle-status');
        Route::patch('projects/{project}/toggle-featured', [ProjectController::class, 'toggleFeatured'])->name('projects.toggle-featured');
        
        // Blogs Management
        Route::resource('blogs', BlogController::class);
        Route::patch('blogs/{blog}/toggle-published', [BlogController::class, 'togglePublished'])->name('blogs.toggle-published');
        Route::patch('blogs/{blog}/toggle-featured', [BlogController::class, 'toggleFeatured'])->name('blogs.toggle-featured');
        
        // Reviews Management
        // Define specific routes before resource routes to avoid conflicts
        Route::get('reviews/export', [ReviewController::class, 'export'])->name('reviews.export');
        Route::get('reviews/import', [ReviewController::class, 'showImport'])->name('reviews.show-import');
        Route::post('reviews/import', [ReviewController::class, 'import'])->name('reviews.import');
        Route::get('reviews/template', [ReviewController::class, 'downloadTemplate'])->name('reviews.template');
        Route::delete('reviews/bulk-delete', [ReviewController::class, 'bulkDelete'])->name('reviews.bulk-delete');
        Route::patch('reviews/bulk-approve', [ReviewController::class, 'bulkApprove'])->name('reviews.bulk-approve');
        
        Route::resource('reviews', ReviewController::class);
        Route::patch('reviews/{review}/toggle-approved', [ReviewController::class, 'toggleApproved'])->name('reviews.toggle-approved');
        Route::patch('reviews/{review}/toggle-featured', [ReviewController::class, 'toggleFeatured'])->name('reviews.toggle-featured');
        
        // Slider Management
        Route::resource('sliders', SliderController::class);
        Route::patch('sliders/{slider}/toggle-active', [SliderController::class, 'toggleActive'])->name('sliders.toggle-active');
        
        // Contacts Management
        Route::resource('contacts', ContactController::class)->only(['index', 'show', 'destroy']);
        Route::patch('contacts/{contact}/mark-read', [ContactController::class, 'markAsRead'])->name('contacts.mark-read');
        Route::patch('contacts/{contact}/mark-unread', [ContactController::class, 'markAsUnread'])->name('contacts.mark-unread');
        Route::patch('contacts/mark-all-read', [ContactController::class, 'markAllAsRead'])->name('contacts.mark-all-read');
        Route::delete('contacts/bulk-delete', [ContactController::class, 'bulkDelete'])->name('contacts.bulk-delete');
        
        // TC Requests Management
        Route::resource('tc-requests', TcRequestController::class)->only(['index', 'show', 'destroy']);
        Route::patch('tc-requests/{tcRequest}/mark-read', [TcRequestController::class, 'markAsRead'])->name('tc-requests.mark-read');
        Route::patch('tc-requests/{tcRequest}/mark-unread', [TcRequestController::class, 'markAsUnread'])->name('tc-requests.mark-unread');
        Route::patch('tc-requests/mark-all-read', [TcRequestController::class, 'markAllAsRead'])->name('tc-requests.mark-all-read');
        Route::delete('tc-requests/bulk-delete', [TcRequestController::class, 'bulkDelete'])->name('tc-requests.bulk-delete');
        Route::get('tc-requests/{tcRequest}/download-file', [TcRequestController::class, 'downloadFile'])->name('tc-requests.download-file');
        
        // Users Management
        Route::resource('users', UserController::class);
        Route::patch('users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');
        
        // Settings (placeholder routes)
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', function () {
                return view('admin.settings.index');
            })->name('index');
        });
    });
});
