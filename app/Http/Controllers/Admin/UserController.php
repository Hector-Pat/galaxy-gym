<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Lista paginada de usuarios.
     */

    public function index()
    {
        // Se obtienen los usuarios con su rol asociado
        $users = User::with('role')->paginate(10);

        // Se obtienen todos los roles para edición inline
        $roles = Role::all();

        // Se envían ambas colecciones a la vista
        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Muestra el formulario de edición.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Actualiza rol y estado del usuario.
     */
    public function update(Request $request, User $user)
    {
        // Validación completa de los campos editables
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'role_id' => 'required|exists:roles,id',
            'active'  => 'required|boolean',
        ]);

        // Actualización explícita de los atributos permitidos
        $user->update([
            'name'    => $request->name,
            'email'   => $request->email,
            'role_id' => $request->role_id,
            'active'  => $request->active,
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuario actualizado correctamente');
    }


    /**
     * Desactiva el usuario (no se elimina físicamente).
     */
    public function destroy(User $user)
    {
        $user->update(['active' => false]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuario desactivado');
    }
}
