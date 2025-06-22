<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\RatingController;

Route::get('/', function () {
    return redirect()->route('dashboard');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    // User management routes
    Route::resource('users', UserController::class);

    // Kriteria management routes
    Route::resource('kriteria', KriteriaController::class);

    // Alternatif management routes
    Route::resource('alternatif', AlternatifController::class);
    Route::get('alternatif-ranking', [AlternatifController::class, 'ranking'])->name('alternatif.ranking');

    // Rating management routes
    Route::resource('rating', RatingController::class)->except(['create', 'store']);
    Route::get('rating-batch/create', [RatingController::class, 'createBatch'])->name('rating.createBatch');
    Route::post('rating-batch', [RatingController::class, 'storeBatch'])->name('rating.storeBatch');
});

require __DIR__.'/auth.php';
