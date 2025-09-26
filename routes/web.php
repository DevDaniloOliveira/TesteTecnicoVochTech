<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\EconomicGroups;
Route::view('/', 'welcome');
Route::middleware(['auth'])->group(function () {
    Route::view('dashboard', 'dashboard')
        ->middleware(['verified'])
        ->name('dashboard');

    Route::view('profile', 'profile')
        ->name('profile');

    //Rotas Grupo Econômico
    Route::get('/economic-groups', EconomicGroups::class)->name('economic-groups');
});

require __DIR__ . '/auth.php';
