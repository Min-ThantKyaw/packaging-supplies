<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Create or update the shop owner account from the environment.
     */
    public function run(): void
    {
        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');

        if (blank($email) || blank($password)) {
            $this->command?->warn('ADMIN_EMAIL and ADMIN_PASSWORD are not set; skipping the owner account.');

            return;
        }

        $user = User::firstOrNew(['email' => $email]);

        $user->forceFill([
            'name' => $user->name ?? 'Shop Owner',
            'email_verified_at' => $user->email_verified_at ?? now(),
            'password' => $password,
            'role' => UserRole::Admin,
        ])->save();
    }
}
