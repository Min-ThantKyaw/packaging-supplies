<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AdminMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Route::middleware(['auth:sanctum', 'admin'])
            ->get('/api/test/admin', fn () => response()->json(['ok' => true]));
    }

    public function test_guests_are_unauthenticated(): void
    {
        $this->getJson('/api/test/admin')->assertUnauthorized();
    }

    public function test_customers_are_forbidden(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $this->getJson('/api/test/admin')->assertForbidden();
    }

    public function test_admins_are_allowed(): void
    {
        Sanctum::actingAs(User::factory()->admin()->create());

        $this->getJson('/api/test/admin')
            ->assertOk()
            ->assertJson(['ok' => true]);
    }
}
