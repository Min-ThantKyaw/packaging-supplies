<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_register_and_receives_token_with_expiry(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'Shop Owner',
            'email' => 'owner@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.user.email', 'owner@example.com')
            ->assertJsonPath('data.user.role', 'owner')
            ->assertJsonStructure(['data' => ['token', 'token_type', 'expires_at']]);

        $this->assertDatabaseHas('users', ['email' => 'owner@example.com', 'role' => 'owner']);
    }

    public function test_owner_can_login(): void
    {
        User::factory()->create(['email' => 'owner@example.com', 'password' => 'password123']);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'owner@example.com',
            'password' => 'password123',
        ]);

        $response->assertOk()
            ->assertJsonPath('data.user.email', 'owner@example.com')
            ->assertJsonStructure(['data' => ['token', 'expires_at']]);
    }

    public function test_login_fails_with_invalid_credentials(): void
    {
        User::factory()->create(['email' => 'owner@example.com']);

        $this->postJson('/api/auth/login', [
            'email' => 'owner@example.com',
            'password' => 'wrong-password',
        ])->assertUnauthorized();
    }

    public function test_authenticated_owner_can_fetch_profile(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->getJson('/api/auth/me')
            ->assertOk()
            ->assertJsonPath('data.email', $user->email)
            ->assertJsonPath('data.role', 'owner');
    }

    public function test_guest_cannot_fetch_profile(): void
    {
        $this->getJson('/api/auth/me')->assertUnauthorized();
    }

    public function test_refresh_rotates_the_token(): void
    {
        $user = User::factory()->create();
        $oldToken = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withToken($oldToken)->postJson('/api/auth/refresh');

        $response->assertOk()->assertJsonStructure(['data' => ['token', 'expires_at']]);
        $newToken = $response->json('data.token');
        $this->assertNotSame($oldToken, $newToken);

        Auth::forgetGuards();

        $this->withToken($oldToken)->getJson('/api/auth/me')->assertUnauthorized();
        $this->withToken($newToken)->getJson('/api/auth/me')->assertOk();
    }

    public function test_owner_can_logout(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        $this->withToken($token)->postJson('/api/auth/logout')->assertOk();

        $this->assertDatabaseCount('personal_access_tokens', 0);

        Auth::forgetGuards();

        $this->withToken($token)->getJson('/api/auth/me')->assertUnauthorized();
    }
}
