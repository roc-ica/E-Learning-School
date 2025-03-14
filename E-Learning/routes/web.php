<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Home Route
Route::get('/', function () {
    return view('home'); // Ensure resources/views/home.blade.php exists
})->name('home');

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Optionally, a dashboard route
    Route::get('/dashboard', function () {
        return view('dashboard'); // Optional: create resources/views/dashboard.blade.php
    })->name('dashboard');
});

// Authentication Routes
require __DIR__.'/auth.php';
