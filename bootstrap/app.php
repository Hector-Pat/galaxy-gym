<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RoleMiddleware;

return Application::configure(basePath: dirname(__DIR__))

    /**
     * Configuración de rutas de la aplicación.
     * - web.php: rutas web (Blade, sesiones, CSRF)
     * - console.php: comandos Artisan
     * - health: endpoint de salud
     */
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    /**
     * Registro de middlewares.
     *
     * En Laravel 11+ ya no existe Http\Kernel.php.
     * Los middlewares se registran aquí mediante alias.
     *
     * El alias 'role' permitirá usar:
     * middleware('role:admin')
     * middleware('role:admin,recepcionista')
     */
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => RoleMiddleware::class,
        ]);
    })

    /**
     * Configuración del manejo de excepciones.
     */
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })

    ->create();
