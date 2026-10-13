<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Seed the site-owner admin account.
     *
     * Default credentials (override via .env):
     *   email    — ADMIN_EMAIL    (default: admin@packaging-supplies.com)
     *   password — ADMIN_PASSWORD (default: password)
     */
    public function run(): void
    {
        $email = (string) env('ADMIN_EMAIL', 'admin@packaging-supplies.com');
        $password = (string) env('ADMIN_PASSWORD', 'password');

        $admin = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Site Admin',
                'phone' => '09123456789',
                'shop_name' => 'Packaging Supplies',
                'password' => Hash::make($password),
            ]
        );

        // role / is_active / email_verified_at are not mass-assignable on the
        // User model, so set them explicitly.
        $admin->forceFill([
            'role' => 'admin',
            'is_active' => true,
            'email_verified_at' => $admin->email_verified_at ?? now(),
        ])->save();

        if ($this->command) {
            $this->command->info("Admin account ready — {$email}");
        }
    }
}
