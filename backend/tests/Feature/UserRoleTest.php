<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_users_are_customers(): void
    {
        $user = User::factory()->create();

        $this->assertSame(UserRole::Customer, $user->role);
        $this->assertFalse($user->isAdmin());
    }

    public function test_role_cannot_be_mass_assigned(): void
    {
        $user = User::create([
            'name' => 'Sneaky Customer',
            'email' => 'sneaky@example.com',
            'password' => 'password',
            'role' => UserRole::Admin->value,
        ]);

        $this->assertSame(UserRole::Customer, $user->fresh()->role);
    }
}
