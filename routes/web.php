<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Redirect the root domain to the Admin Panel
Route::get('/', function () {
    return redirect()->route('admin.dashboard');
})->name('home');

// Dashboard (can be left for auth scaffolding, or point to admin)
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// SEO Sitemap
Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index']);

// Language Switcher
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'fr', 'ar'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');

// Auth Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
