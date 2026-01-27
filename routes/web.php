<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// Public website routes
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/services/{service}', [PageController::class, 'service'])->name('services.show');
Route::get('/projects', [PageController::class, 'projects'])->name('projects');
Route::get('/projects/{project}', [PageController::class, 'project'])->name('projects.show');
Route::get('/blog', [PageController::class, 'blog'])->name('blog');
Route::get('/blog/{blog}', [PageController::class, 'blogPost'])->name('blog.show');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

// Form submissions
Route::post('/contact', [PageController::class, 'contactSubmit'])->name('contact.submit');
Route::post('/tc-request', [PageController::class, 'tcRequestSubmit'])->name('tc-request.submit');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
