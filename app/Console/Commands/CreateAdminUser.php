<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin user interactively';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Create a New Admin User');
        
        $name = $this->ask('Name');
        $email = $this->ask('Email Address');
        
        if (\App\Models\User::where('email', $email)->exists()) {
            $this->error('A user with this email already exists.');
            return 1;
        }

        $password = $this->secret('Password');
        $confirmPassword = $this->secret('Confirm Password');

        if ($password !== $confirmPassword) {
            $this->error('Passwords do not match.');
            return 1;
        }

        \App\Models\User::create([
            'name' => $name,
            'email' => $email,
            'password' => \Illuminate\Support\Facades\Hash::make($password),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $this->info('Admin user created successfully!');
        return 0;
    }
}
