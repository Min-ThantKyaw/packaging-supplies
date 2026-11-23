<?php

namespace Tests\Feature;

use Tests\TestCase;

class CorsTest extends TestCase
{
    public function test_frontend_origin_is_allowed(): void
    {
        $origin = config('cors.allowed_origins')[0];

        $this->withHeaders(['Origin' => $origin])
            ->getJson('/api/health')
            ->assertOk()
            ->assertHeader('Access-Control-Allow-Origin', $origin);
    }

    public function test_unknown_origin_is_rejected_when_multiple_origins_are_allowed(): void
    {
        // php-cors sets the configured origin unconditionally when exactly one
        // origin is allowed. With multiple origins it echoes only a match.
        config(['cors.allowed_origins' => [
            'http://localhost:5173',
            'http://localhost:4173',
        ]]);

        $this->withHeaders(['Origin' => 'http://not-allowed.test'])
            ->getJson('/api/health')
            ->assertOk()
            ->assertHeaderMissing('Access-Control-Allow-Origin');
    }

    public function test_preflight_allows_authorization_header(): void
    {
        $origin = config('cors.allowed_origins')[0];

        $this->withHeaders([
            'Origin' => $origin,
            'Access-Control-Request-Method' => 'POST',
            'Access-Control-Request-Headers' => 'authorization,content-type',
        ])
            ->options('/api/login')
            ->assertHeader('Access-Control-Allow-Origin', $origin);
    }
}
