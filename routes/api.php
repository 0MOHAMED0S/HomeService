<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\OtpController;

use App\Http\Controllers\Api\Provider\ProviderProfileController;
use App\Http\Controllers\Api\Admin\ProviderApplicationController;
use App\Http\Controllers\Api\ProfessionController;

Route::prefix('auth')->group(function () {
    // Unauthenticated routes
    Route::post('/send-otp', [OtpController::class, 'sendOtp']);
    Route::post('/verify-otp', [OtpController::class, 'verifyOtp']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // Authenticated routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/refresh', [AuthController::class, 'refreshToken']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/update-location', [AuthController::class, 'updateLocation']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    
    Route::get('/professions', [ProfessionController::class, 'index']);
    
    // Provider Profile Routes
    Route::prefix('provider')->middleware('check.provider')->group(function () {
        Route::get('/profile', [ProviderProfileController::class, 'show']);
        Route::post('/profile', [ProviderProfileController::class, 'store']);
    });

    // Admin Routes
    Route::prefix('admin')->middleware('check.admin')->group(function () {
        Route::get('/applications', [ProviderApplicationController::class, 'index']);
        Route::get('/applications/{id}', [ProviderApplicationController::class, 'show']);
        Route::post('/applications/{id}/review', [ProviderApplicationController::class, 'review']);
    });
});