<?php

use App\Http\Controllers\WordListController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/lists', [WordListController::class, 'index'])->name('lists.index');
    Route::get('/lists/create-list', [WordListController::class, 'create'])->name('lists.create');
    Route::post('/lists', [WordListController::class, 'store'])->name('lists.store');
});

require __DIR__.'/auth.php';
