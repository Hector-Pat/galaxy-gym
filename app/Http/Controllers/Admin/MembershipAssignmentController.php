<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Membership;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MembershipAssignmentController extends Controller
{
    /**
     * Muestra el formulario de asignación de membresía.
     */
    public function create()
    {
        // Solo clientes activos
        $clients = User::whereHas('role', function ($q) {
            $q->where('name', 'cliente');
        })->where('active', true)->get();

        // Solo membresías activas
        $memberships = Membership::where('active', true)->get();

        return view('admin.memberships.assign', compact('clients', 'memberships'));
    }

    /**
     * Asigna una membresía a un cliente.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'       => 'required|exists:users,id',
            'membership_id' => 'required|exists:memberships,id',
            'start_date'    => 'required|date',
        ]);

        $user = User::findOrFail($request->user_id);
        $membership = Membership::findOrFail($request->membership_id);

        // Cálculo de fecha de expiración usando el catálogo
        $startDate = Carbon::parse($request->start_date);
        $endDate = $startDate->copy()->addDays($membership->duration_days);

        // Asignación final
        $user->update([
            'membership_id'         => $membership->id,
            'membership_start_date' => $startDate,
            'membership_end_date'   => $endDate,
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Membresía asignada correctamente');
    }
}
