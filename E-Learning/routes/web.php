<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WordListController;
use App\Http\Controllers\LearnController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/lists/public', [WordListController::class, 'publicLists'])->name('lists.public');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/lists', [WordListController::class, 'index'])->name('lists.index');
    Route::get('/lists/create', [WordListController::class, 'create'])->name('lists.create');
    Route::post('/lists', [WordListController::class, 'store'])->name('lists.store');
    Route::get('/lists/{wordList}/edit', [WordListController::class, 'edit'])->name('lists.edit');
    Route::put('/lists/{wordList}', [WordListController::class, 'update'])->name('lists.update');
    Route::delete('/lists/{wordList}', [WordListController::class, 'destroy'])->name('lists.destroy');

    // Learning session routes
    Route::post('/learn/{wordList}/save-score', [LearnController::class, 'saveScore'])->name('learn.save-score');
    Route::get('/lists/{wordList}/history', [LearnController::class, 'history'])->name('lists.history');
});

Route::get('/lists/{wordList}', [WordListController::class, 'view'])->name('lists.view');
Route::get('/learn/{wordList}', [LearnController::class, 'learn'])->name('learn');
