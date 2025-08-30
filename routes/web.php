<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\CardTemplateController;
use App\Http\Controllers\Admin\CardController;
use App\Http\Controllers\CardVerificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Rota pública de verificação de cartão
Route::get('/v/{token}', [CardVerificationController::class, 'verify'])
    ->name('card.verify');

// Rotas protegidas por autenticação
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rotas administrativas
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Colaboradores
        Route::resource('employees', EmployeeController::class);

        // Templates de cartão
        Route::resource('card-templates', CardTemplateController::class);

        // Cartões
        Route::resource('cards', CardController::class);
        Route::post('cards/{card}/revoke', [CardController::class, 'revoke'])->name('cards.revoke');
        Route::get('cards/{card}/preview', [CardController::class, 'preview'])->name('cards.preview');
        Route::get('cards/{card}/export/{format}', [CardController::class, 'export'])->name('cards.export');

        // Relatórios
        Route::get('reports/employees', [ReportController::class, 'employees'])->name('reports.employees');
        Route::get('reports/cards', [ReportController::class, 'cards'])->name('reports.cards');
    });
});

require __DIR__.'/auth.php';
