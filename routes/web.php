<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AltaDocenteController;
use App\Http\Controllers\EstablecerCoordinadorController;
use App\Http\Controllers\EstablecerTutorController;
use App\Http\Controllers\EstablecerDocenciaController;
use App\Http\Controllers\BajaDocenteController;

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

Route::middleware(['auth'])->group(function () {
    Route::get('/establecer-docencia', [EstablecerDocenciaController::class, 'index'])
        ->name('establecer_docencia.index');

    Route::post('/establecer-docencia', [EstablecerDocenciaController::class, 'store'])
        ->name('establecer_docencia.store');

    Route::delete('/establecer-docencia/{id}', [EstablecerDocenciaController::class, 'destroy'])
        ->name('establecer_docencia.destroy');

    Route::get('/modulos-por-ciclo/{id}', [EstablecerDocenciaController::class, 'getModulosPorCiclo']);

});

Route::middleware(['auth'])->group(function () {
    Route::get('/docentes/baja', [BajaDocenteController::class, 'index'])->name('docentes.index');
    Route::delete('/docentes/baja/{dni}', [BajaDocenteController::class, 'destroy'])->name('docentes.destroy');
});

require __DIR__.'/auth.php';
