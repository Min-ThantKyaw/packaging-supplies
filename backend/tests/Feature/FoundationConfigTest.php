<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Sanctum\HasApiTokens;
use Tests\TestCase;

class FoundationConfigTest extends TestCase
{
    public function test_application_timezone_is_configurable(): void
    {
        $this->assertSame('Asia/Yangon', config('app.timezone'));
    }

    public function test_sanctum_tokens_have_an_expiration(): void
    {
        $this->assertSame(10080, config('sanctum.expiration'));
    }

    public function test_user_model_issues_api_tokens(): void
    {
        $this->assertContains(HasApiTokens::class, class_uses_recursive(User::class));
    }
}
