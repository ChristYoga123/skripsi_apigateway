<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\Course\KelasController;
use App\Http\Controllers\Transaction\TransactionController;

Route::prefix('course')->group(function()
{
    // User Service
    Route::prefix('auth')->group(function()
    {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
    });

    // Course Service
    Route::prefix('kelas')->group(function()
    {
        Route::get('/', [KelasController::class, 'index']);
    });

    // Transaction Service
    Route::get('/dashboard/orders', [TransactionController::class, 'index']);
    Route::post('/checkout/{slug}/daftar', [TransactionController::class, 'daftar'])->middleware('auth.api');
});
