<?php

use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Api\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{slug}', [ProductController::class, 'show']);

Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders/{orderId}', [OrderController::class, 'show']);

Route::prefix('admin')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);

        Route::get('/orders', [AdminOrderController::class, 'index']);
        Route::get('/orders/{orderId}', [AdminOrderController::class, 'show']);
        Route::patch('/orders/{orderId}', [AdminOrderController::class, 'update']);

        Route::get('/products', [AdminProductController::class, 'index']);
        Route::post('/products', [AdminProductController::class, 'store']);
        Route::put('/products/{productId}', [AdminProductController::class, 'update']);
        Route::delete('/products/{productId}', [AdminProductController::class, 'destroy']);
    });
});
