<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MembershipController;
use App\Http\Controllers\Admin\MembershipAssignmentController;

/*
|--------------------------------------------------------------------------
| Ruta pública
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Dashboard principal
| Requiere autenticación (Laravel Breeze)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Perfil del usuario autenticado
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Rutas de prueba por rol (validación de middleware)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->get('/admin-only', function () {
    return 'Acceso exclusivo para administradores';
});

/*
|--------------------------------------------------------------------------
| Rutas de administración (ADMIN + RECEPCIONISTA)
|--------------------------------------------------------------------------
| - Gestión de membresías
| - Asignación de membresías a clientes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin,recepcionista'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
         * CRUD de Membresías (catálogo)
         */
        Route::resource('memberships', MembershipController::class)
            ->except(['create', 'show', 'edit']);

        /*
         * Asignación de membresía a clientes
         */
        Route::get('/memberships/assign', [MembershipAssignmentController::class, 'create'])
            ->name('memberships.assign');

        Route::post('/memberships/assign', [MembershipAssignmentController::class, 'store'])
            ->name('memberships.assign.store');
    });

/*
|--------------------------------------------------------------------------
| Rutas de administración de usuarios (SOLO ADMIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('users', UserController::class)
            ->except(['create', 'store', 'show']);
    });

/*
|--------------------------------------------------------------------------
| Rutas de autenticación (Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
