<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Ruta para mostrar el formulario de reservas
Route::get('/reservations', function () {
    return view('reservations');
})->name('reservations');

// Ruta para procesar el formulario de reservas (debes crear un controlador para esto)
Route::post('/reservations/guardar', [App\Http\Controllers\ReservationController::class, 'store'])->name('reservations.guardar');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
