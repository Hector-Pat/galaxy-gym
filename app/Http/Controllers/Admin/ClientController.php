<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Membership;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Listado de clientes (usuarios con rol cliente).
     */
    public function index()
    {
        $clients = User::with('membership')
            ->whereHas('role', fn ($q) => $q->where('name', 'cliente'))
            ->paginate(10);

        $memberships = Membership::where('active', true)->get();

        return view('admin.clients.index', compact('clients', 'memberships'));
    }


    /**
     * Formulario de edición de cliente.
     */
    public function edit(User $client)
    {
        $memberships = Membership::where('active', true)->get();

        return view('admin.clients.edit', compact('client', 'memberships'));
    }

    /**
     * Actualiza datos del cliente y su membresía.
     */
    public function update(Request $request, User $client)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'active' => 'required|boolean',
            'membership_id' => 'nullable|exists:memberships,id',
        ]);

        $client->update($request->only('name', 'email', 'active'));

        if ($request->membership_id) {
            $membership = Membership::find($request->membership_id);

            $client->membership_id = $membership->id;
            $client->membership_start_date = now();
            $client->membership_end_date = now()->addDays($membership->duration_days);
        } else {
            $client->membership_id = null;
            $client->membership_start_date = null;
            $client->membership_end_date = null;
        }

        $client->save();

        return redirect()
            ->route('admin.clients.index')
            ->with('success', 'Cliente actualizado correctamente');
    }

    /**
     * Desactivación lógica del cliente.
     */
    public function destroy(User $client)
    {
        $client->update(['active' => false]);

        return redirect()
            ->route('admin.clients.index')
            ->with('success', 'Cliente desactivado');
    }
}
