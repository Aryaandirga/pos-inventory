<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\OrderApiController;

Route::middleware('auth.apitoken')->group(function () {
    // Products
    Route::get('/products', [ProductApiController::class, 'index']);
    Route::get('/products/{slug}', [ProductApiController::class, 'show']);
    Route::get('/categories', [ProductApiController::class, 'categories']);

    // Orders dari Ecommerce
    Route::post('/orders', [OrderApiController::class, 'store']);
});