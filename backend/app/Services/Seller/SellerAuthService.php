<?php

namespace App\Services\Seller;

use App\Models\User;

class SellerAuthService
{
	public function authenticate(array $credentials): ?User
	{
		$user = User::where('email', $credentials['email'])
			->where('is_active', false)
			->first();

		if (!$user || !password_verify($credentials['password'], $user->password)) {
			return null;
		}
		// if ($user->is_active === false) {
		// 	return null;
		// }
		return $user;
	}

	public function generateToken(User $user, string $tokenName = 'login_token'): string
	{
		return $user->createToken($tokenName)->plainTextToken;
	}

	public function logout(User $user): void
	{
		$user->tokens()->delete();
	}
}
