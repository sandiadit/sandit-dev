<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\ExperienceController;
use App\Http\Controllers\Dashboard\ProjectController;
use App\Http\Controllers\Dashboard\DocController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Dashboard\CertificateController;
use Illuminate\Support\Facades\Route;


Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/projects', [PublicController::class, 'projects'])->name('projects');
Route::get('/projects/{project:slug}', [PublicController::class, 'projectDetail'])->name('projects.show');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/dashboard/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('dashboard/experiences', ExperienceController::class)
        ->names('dashboard.experiences')
        ->except(['show']);

    Route::resource('dashboard/projects', ProjectController::class)
        ->names('dashboard.projects')
        ->except(['show']);

    Route::resource('dashboard/projects.docs', DocController::class)
        ->names('dashboard.projects.docs')
        ->except(['show']);

    Route::resource('dashboard/certificates', CertificateController::class)
        ->names('dashboard.certificates')
        ->except(['show']);
});

Route::get('/contact', [PublicController::class, 'contact'])->name('contact');
Route::get('/certificates', [PublicController::class, 'certificates'])->name('certificates');

require __DIR__ . '/auth.php';