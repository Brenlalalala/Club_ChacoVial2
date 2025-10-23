<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\Admin\ReservaAdminController;
use App\Http\Controllers\Admin\InstalacionController; 

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


// Rutas públicas
Route::get('/reservar/{instalacion?}', [ReservaController::class, 'create'])->name('reservas.create');
Route::post('/reservar', [ReservaController::class, 'store'])->name('reservas.store');
Route::get('/reserva/confirmacion/{id}', [ReservaController::class, 'confirmacion'])->name('reservas.confirmacion');
Route::post('/api/verificar-disponibilidad', [ReservaController::class, 'verificarDisponibilidad'])->name('reservas.verificar');

// Rutas admin (proteger con middleware auth)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/reservas', [ReservaAdminController::class, 'index'])->name('reservas.index');
    Route::get('/reservas/{id}', [ReservaAdminController::class, 'show'])->name('reservas.show');
    Route::post('/reservas/{id}/confirmar', [ReservaAdminController::class, 'confirmar'])->name('reservas.confirmar');
    Route::post('/reservas/{id}/cancelar', [ReservaAdminController::class, 'cancelar'])->name('reservas.cancelar');
    Route::get('/reservas/{id}/editar', [ReservaAdminController::class, 'edit'])->name('reservas.edit');
    Route::put('/reservas/{id}', [ReservaAdminController::class, 'update'])->name('reservas.update');

    Route::resource('instalaciones', InstalacionController::class);
    Route::post('/instalaciones/{id}/toggle', [InstalacionController::class, 'toggleActiva'])->name('instalaciones.toggle');
});