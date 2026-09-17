<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    Route::get('/login', function () {
        return "Admin Login Page (Web)";
    })->name('admin.login');
    
    // Add other Admin Web routes here
});
