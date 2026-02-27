<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'make:admin';

    protected $description = 'Create an admin user account';

    public function handle(): int
    {
        $name = $this->ask('Name');
        $email = $this->ask('Email');

        if (User::where('email', $email)->exists()) {
            $this->error("A user with email {$email} already exists.");
            return self::FAILURE;
        }

        $password = $this->secret('Password');
        $passwordConfirmation = $this->secret('Confirm password');

        if ($password !== $passwordConfirmation) {
            $this->error('Passwords do not match.');
            return self::FAILURE;
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info('Admin user created successfully!');
        $this->table(['Name', 'Email'], [[$user->name, $user->email]]);

        return self::SUCCESS;
    }
}
