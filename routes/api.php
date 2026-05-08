<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;

Route::middleware('auth.apitoken')->group(function () {
    Route::get('/products', [ProductApiController::class, 'index']);
    Route::get('/products/{slug}', [ProductApiController::class, 'show']);
});