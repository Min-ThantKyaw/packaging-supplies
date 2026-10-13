<?php

use Illuminate\Support\Facades\Route;

Route::get('/api/health', function () {
    return response()->json(['status' => 200, 'message' => 'Hello from the API!']);
});
