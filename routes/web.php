<?php

use App\Livewire\AuditLogs;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\EconomicGroups;
use App\Livewire\Employees;
use App\Livewire\Flags;
use App\Livewire\Reports;
use App\Livewire\Units;
use Illuminate\Support\Facades\Storage;


Volt::route('/', 'pages.auth.login')->name('/');
Route::middleware(['auth'])->group(function () {
    Route::view('dashboard', 'dashboard')->middleware(['verified'])->name('dashboard');

    Route::view('profile', 'profile')->name('profile');

    //Rotas Relatórios
    Route::get('/reports', Reports::class)->name('reports');
    //Rotas Grupo Econômico
    Route::get('/economic-groups', EconomicGroups::class)->name('economic-groups');
    //Rotas Bandeiras
    Route::get('/flags', Flags::class)->name('flags');
    //Rotas Unidades
    Route::get('/units', Units::class)->name('units');
    //Rotas Colaboradores
    Route::get('/employees', Employees::class)->name('employees');
    Route::get('/audit-logs', AuditLogs::class)->name('audit-logs');

    // Rota para download de arquivos exportados
    Route::get('/exports/download/{filename}', function ($filename) {
        $filePath = 'exports/' . $filename;

        if (!Storage::exists($filePath)) {
            abort(404, 'Arquivo não encontrado');
        }

        return Storage::download($filePath);
    })->name('exports.download');
});

require __DIR__ . '/auth.php';
