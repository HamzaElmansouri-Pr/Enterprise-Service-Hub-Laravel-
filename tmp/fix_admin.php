<?php

// include vendor autoload if needed, but artisan tinker script is easier to run via artisan
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$user = User::where('email', 'admin_test@test.com')->first();
if ($user) {
    $user->role = 'admin';
    $user->save();
    echo "Admin role set for admin_test@test.com\n";
} else {
    User::create([
        'name' => 'Admin Test',
        'email' => 'admin_test@test.com',
        'password' => Hash::make('password'),
    ]);
    // Re-fetch and update since role is not fillable
    $user = User::where('email', 'admin_test@test.com')->first();
    $user->role = 'admin';
    $user->save();
    echo "Admin Test user created with admin role\n";
}
