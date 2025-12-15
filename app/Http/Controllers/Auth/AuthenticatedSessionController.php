<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Muestra la vista de login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Procesa el intento de autenticación.
     * Bloquea usuarios con active = false.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Autenticación estándar (Breeze)
        $request->authenticate();

        $request->session()->regenerate();

        // ===============================
        // BLOQUEO DE USUARIOS INACTIVOS
        // ===============================
        if (! auth()->user()->active) {
            Auth::logout();

            return redirect()
                ->route('user.disabled');
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

