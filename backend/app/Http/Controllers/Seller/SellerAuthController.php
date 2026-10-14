<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Http\Requests\Seller\SellerLoginRequest;
use App\Services\Seller\SellerAuthService;

class SellerAuthController extends Controller
{
    use ApiResponse;

    public function __construct(private SellerAuthService $service) {}

    public function login(SellerLoginRequest $request)
    {
        if (! $this->service->authenticate($request->validated())) {
            return $this->errorResponse('These credentials do not match our records.', 401, 'Invalid credentials');
        }

        $user = $this->service->authenticate($request->validated());
        $token = $this->service->generateToken($user);

        return $this->successResponse(
            [
            'user' => $user,
            'token' => $token,
            ], 
            'Login successful', 200);
    }
}
