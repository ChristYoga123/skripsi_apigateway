<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\Course\KelasController;
use App\Http\Controllers\GatewayController;
use App\Http\Controllers\Transaction\TransactionController;

Route::prefix('course')->group(function()
{
    // User Service
    Route::prefix('auth')->group(function()
    {
        Route::post('register', [GatewayController::class, 'register']);
        Route::post('login', [GatewayController::class, 'login']);
    });

    // Course Service
    Route::prefix('kelas')->group(function()
    {
        Route::get('/', [GatewayController::class, 'kelas']);
    });

    // Transaction Service
    Route::get('/dashboard/orders', [GatewayController::class, 'orders']);
    Route::post('/checkout/{slug}/daftar', [GatewayController::class, 'daftar'])->middleware('auth.api');
});
