<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\ExperienceController; // tambah ini
use App\Http\Controllers\Dashboard\ProjectController;
use App\Http\Controllers\Dashboard\DocController;
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

         Route::resource('dashboard/projects', ProjectController::class)
         ->names('dashboard.projects')
         ->except(['show']);    

         Route::resource('dashboard/projects.docs', DocController::class)
         ->names('dashboard.projects.docs')
         ->except(['show']);
});

require __DIR__.'/auth.php';