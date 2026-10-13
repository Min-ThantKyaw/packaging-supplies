<?php

use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\OwnerController;
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
        Route::post('/login', [IndexController::class, 'authenticate']);
    });

    // Authenticated routes
    Route::middleware('auth')->group(function () {
        Route::get('/', [IndexController::class, 'index'])->name('admin.dashboard');
        Route::get('/owners', [OwnerController::class, 'index'])->name('admin.owners');
        Route::post('/owners', [OwnerController::class, 'store'])->name('admin.owners.store');
        Route::post('/logout', [IndexController::class, 'logout'])->name('admin.logout');
    });
});
