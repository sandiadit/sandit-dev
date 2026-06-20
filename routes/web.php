<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\ExperienceController; // tambah ini
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/dashboard/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('dashboard/experiences', ExperienceController::class)
         ->names('dashboard.experiences') // tambah ini
         ->except(['show']);
});

require __DIR__.'/auth.php';