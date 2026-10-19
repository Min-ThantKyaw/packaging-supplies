<?php

use App\Http\Controllers\Seller\CategoryController;
use App\Http\Controllers\Seller\ProductController;
use App\Http\Controllers\Seller\SellerAuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::get('/health', function(){
        return response()->json([
            'message' => 'ok'
        ]);
    });
    Route::post('/login',    [SellerAuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me',       [SellerAuthController::class, 'me']);
        Route::post('/refresh', [SellerAuthController::class, 'refresh']);
        Route::post('/logout',  [SellerAuthController::class, 'logout']);
    });
});

Route::middleware('auth:sanctum')->prefix('seller')->group(function () {
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::post('/products',   [ProductController::class, 'store']);
});
