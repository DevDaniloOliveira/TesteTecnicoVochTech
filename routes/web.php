<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\EconomicGroups;
use App\Livewire\Employees;
use App\Livewire\Flags;
use App\Livewire\Units;

Route::view('/', 'welcome');
Route::middleware(['auth'])->group(function () {
    Route::view('dashboard', 'dashboard')
        ->middleware(['verified'])
        ->name('dashboard');

    Route::view('profile', 'profile')
        ->name('profile');

    //Rotas Grupo Econômico
    Route::get('/economic-groups', EconomicGroups::class)->name('economic-groups');
    //Rotas Bandeiras
    Route::get('/flags', Flags::class)->name('flags');
    //Rotas Unidades
    Route::get('/units', Units::class)->name('units');
    //Rotas Colaboradores
    Route::get('/employees',Employees::class)->name('employees');
});

require __DIR__ . '/auth.php';
