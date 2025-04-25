<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AltaDocenteController;
use App\Http\Controllers\EstablecerCoordinadorController;
use App\Http\Controllers\EstablecerTutorController;

Route::redirect('/', '/login');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/alta-docente', [AltaDocenteController::class, 'create'])
        ->name('alta_docente');

    Route::post('/alta-docente', [AltaDocenteController::class, 'store'])
        ->name('alta_docente.store');
    Route::get('/comprobar-docente/{dni}', [AltaDocenteController::class, 'comprobarDocente']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/establecer-coordinador', [EstablecerCoordinadorController::class, 'index'])
    ->name('establecer_coordinador.index');

    Route::post('/establecer-coordinador', [EstablecerCoordinadorController::class, 'store'])
    ->name('establecer_coordinador.store');

    Route::delete('/establecer-coordinador/{id}', [EstablecerCoordinadorController::class, 'destroy'])
    ->name('establecer_coordinador.destroy');
});



Route::middleware(['auth'])->group(function () {
    Route::get('/establecer-tutor', [EstablecerTutorController::class, 'index'])
    ->name('establecer_tutor.index');

    Route::post('/establecer-tutor', [EstablecerTutorController::class, 'store'])
    ->name('establecer_tutor.store');

    Route::delete('/tutor/{id}', [EstablecerTutorController::class, 'destroy'])
    ->name('tutor.destroy');
});

require __DIR__.'/auth.php';
