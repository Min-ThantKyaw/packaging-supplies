<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminUserSeederTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        putenv('ADMIN_EMAIL');
        putenv('ADMIN_PASSWORD');

        parent::tearDown();
    }

    public function test_it_creates_the_owner_account(): void
    {
        putenv('ADMIN_EMAIL=owner@example.com');
        putenv('ADMIN_PASSWORD=super-secret');

        $this->seed(AdminUserSeeder::class);

        $user = User::where('email', 'owner@example.com')->firstOrFail();

        $this->assertSame(UserRole::Admin, $user->role);
        $this->assertTrue($user->isAdmin());
        $this->assertTrue(Hash::check('super-secret', $user->password));
    }

    public function test_it_updates_an_existing_owner_without_duplicating(): void
    {
        putenv('ADMIN_EMAIL=owner@example.com');
        putenv('ADMIN_PASSWORD=first-secret');
        $this->seed(AdminUserSeeder::class);

        putenv('ADMIN_PASSWORD=second-secret');
        $this->seed(AdminUserSeeder::class);

        $this->assertSame(1, User::where('email', 'owner@example.com')->count());
        $this->assertTrue(Hash::check('second-secret', User::firstOrFail()->password));
    }
}
