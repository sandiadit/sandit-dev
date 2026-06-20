<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\ExperienceController; // tambah ini
use App\Http\Controllers\Dashboard\ProjectController;
use App\Http\Controllers\Dashboard\DocController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;


// Ganti route '/' yang lama
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/projects', [PublicController::class, 'projects'])->name('projects');
Route::get('/projects/{project:slug}', [PublicController::class, 'projectDetail'])->name('projects.show');

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

Route::get('/contact', function () {
    return view('contact.index');
})->name('contact');

require __DIR__.'/auth.php';