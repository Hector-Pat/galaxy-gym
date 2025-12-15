<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Nueva Promoción</h2>
    </x-slot>

    <div class="p-6 max-w-xl">
        <form method="POST" action="{{ route('admin.promotions.store') }}">
            @csrf

            <div class="mb-4">
                <label>Nombre</label>
                <input type="text" name="name" class="w-full border rounded px-2 py-1" required>
            </div>

            <div class="mb-4">
                <label>Descripción</label>
                <textarea name="description" class="w-full border rounded px-2 py-1"></textarea>
            </div>

            <div class="mb-4">
                <label>Tipo de descuento</label>
                <select name="discount_type" class="w-full border rounded px-2 py-1">
                    <option value="percentage">Porcentaje (%)</option>
                    <option value="fixed">Monto fijo ($)</option>
                </select>
            </div>

            <div class="mb-4">
                <label>Valor del descuento</label>
                <input type="number" step="0.01" name="discount_value"
                       class="w-full border rounded px-2 py-1" required>
            </div>

            <div class="mb-4">
                <label>Membresía</label>
                <select name="membership_id" class="w-full border rounded px-2 py-1">
                    <option value="">Aplica a todas</option>
                    @foreach($memberships as $membership)
                    <option value="{{ $membership->id }}">
                        {{ $membership->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label>Fecha inicio</label>
                <input type="date" name="starts_at" class="w-full border rounded px-2 py-1">
            </div>

            <div class="mb-4">
                <label>Fecha fin</label>
                <input type="date" name="ends_at" class="w-full border rounded px-2 py-1">
            </div>

            <div class="mb-6">
                <label>Activo</label>
                <select name="active" class="w-full border rounded px-2 py-1">
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
            </div>

            <button class="px-4 py-2 bg-green-600 text-white rounded">
                Guardar promoción
            </button>
        </form>
    </div>
</x-app-layout>
