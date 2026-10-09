<?php
use Illuminate\Support\Facades\Route;
Route::get('/test-image', function () {
    return resolve_image_url(App\Models\User::where('role', 'admin')->first()->image);
});
