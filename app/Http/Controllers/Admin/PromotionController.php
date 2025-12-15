<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Models\Membership;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    /**
     * Listado de promociones.
     */
    public function index()
    {
        $promotions = Promotion::with('membership')->paginate(10);

        return view('admin.promotions.index', compact('promotions'));
    }

    /**
     * Formulario de creación.
     */
    public function create()
    {
        $memberships = Membership::where('active', true)->get();

        return view('admin.promotions.create', compact('memberships'));
    }

    /**
     * Almacena una nueva promoción.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'membership_id' => 'nullable|exists:memberships,id',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'active' => 'required|boolean',
        ]);

        Promotion::create($request->all());

        return redirect()
            ->route('admin.promotions.index')
            ->with('success', 'Promoción creada correctamente');
    }

    /**
     * Formulario de edición.
     */
    public function edit(Promotion $promotion)
    {
        $memberships = Membership::where('active', true)->get();

        return view('admin.promotions.edit', compact('promotion', 'memberships'));
    }

    /**
     * Actualiza una promoción existente.
     */
    public function update(Request $request, Promotion $promotion)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'membership_id' => 'nullable|exists:memberships,id',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'active' => 'required|boolean',
        ]);

        $promotion->update($request->all());

        return redirect()
            ->route('admin.promotions.index')
            ->with('success', 'Promoción actualizada correctamente');
    }

    /**
     * Desactivación lógica de la promoción.
     */
    public function destroy(Promotion $promotion)
    {
        $promotion->update(['active' => false]);

        return redirect()
            ->route('admin.promotions.index')
            ->with('success', 'Promoción desactivada');
    }
}
