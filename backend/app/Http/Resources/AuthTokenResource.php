<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;

/**
 * Response for a successful register or login: the Sanctum bearer token and
 * the authenticated user.
 */
class AuthTokenResource extends Resource
{
    public function __construct(User $user, private readonly string $token)
    {
        parent::__construct($user);
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'token' => $this->token,
            'token_type' => 'Bearer',
            'user' => UserResource::make($this->resource),
        ];
    }
}
