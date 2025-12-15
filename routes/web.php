<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/**
 * Ruta pública de inicio.
 */
Route::get('/', function () {
    return view('welcome');
});

/**
 * Dashboard principal.
 * Requiere autenticación y verificación (Breeze).
 */
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/**
 * Rutas de perfil del usuario autenticado.
 */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/**
 * ===============================
 * RUTAS DE PRUEBA POR ROL
 * ===============================
 * Estas rutas existen únicamente para validar
 * el funcionamiento del middleware de roles.
 */

/**
 * Acceso exclusivo para administradores.
 */
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin-only', function () {
        return 'Acceso solo para administradores';
    });
});

/**
 * Acceso permitido para administradores y recepcionistas.
 */
Route::middleware(['auth', 'role:admin,recepcionista'])->group(function () {
    Route::get('/staff-only', function () {
        return 'Acceso para admin y recepcionista';
    });
});

/**
 * Rutas de autenticación (login, register, logout, etc.).
 */
require __DIR__.'/auth.php';
