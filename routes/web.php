<?php

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

// Ruta para login 
Route::get('/admin/login', function () {
    return view('admin.login');
})->name('admin.login');

Route::post('/admin/login', [App\Http\Controllers\Admin\LoginController::class, 'authenticate'])->name('admin.login.submit');