<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\SellerLoginRequest;
use App\Services\Seller\SellerAuthService;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;

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

    public function logout()
    {
        $user = Auth::user();
        $this->service->logout($user);

        return $this->successResponse([], 'Logout successful', 200);
    }
}
