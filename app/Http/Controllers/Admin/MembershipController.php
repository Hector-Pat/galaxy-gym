<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index()
    {
        $memberships = Membership::paginate(10);
        return view('admin.memberships.index', compact('memberships'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
        ]);

        Membership::create($request->only('name', 'price', 'duration_days'));

        return back()->with('success', 'Membresía creada');
    }

    public function update(Request $request, Membership $membership)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'active' => 'required|boolean',
        ]);

        $membership->update($request->only('name', 'price', 'duration_days', 'active'));

        return back()->with('success', 'Membresía actualizada');
    }

    public function destroy(Membership $membership)
    {
        $membership->update(['active' => false]);
        return back()->with('success', 'Membresía desactivada');
    }
}
