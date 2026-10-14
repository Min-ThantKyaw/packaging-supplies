<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\SellerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin (Blade) routes — site owner console
|--------------------------------------------------------------------------
| GET  /admin          → dashboard (auth)
| GET  /admin/login    → sign-in form (guest)
| POST /admin/login    → authenticate (guest)
| POST /admin/logout   → sign out (auth)
*/
Route::prefix('admin')->group(function () {
    // Guest routes
    Route::middleware('guest')->group(function () {
        Route::get('/login', [IndexController::class, 'login'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'authenticate']);
    });

    // Authenticated routes
    Route::middleware('auth')->group(function () {
        Route::get('/', [IndexController::class, 'index'])->name('admin.dashboard');
        Route::get('/sellers', [SellerController::class, 'index'])->name('admin.sellers');
        Route::post('/sellers', [SellerController::class, 'store'])->name('admin.sellers.store');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    });
});
