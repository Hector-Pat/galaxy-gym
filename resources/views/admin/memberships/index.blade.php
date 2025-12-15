<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Membresías</h2>
    </x-slot>

    <div class="p-6">

        @if(session('success'))
        <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif

        {{-- Crear nueva membresía --}}
        <form method="POST" action="{{ route('admin.memberships.store') }}" class="mb-6 flex gap-2">
            @csrf
            <input name="name" placeholder="Nombre" class="border px-2 py-1">
            <input name="price" placeholder="Precio" type="number" step="0.01" class="border px-2 py-1">
            <input name="duration_days" placeholder="Días" type="number" class="border px-2 py-1">
            <button class="bg-blue-600 text-white px-4 py-1 rounded">Agregar</button>
        </form>

        <table class="w-full border">
            <thead class="bg-gray-100">
            <tr>
                <th class="p-2">Nombre</th>
                <th class="p-2 text-center">Precio</th>
                <th class="p-2 text-center">Duración</th>
                <th class="p-2 text-center">Activo</th>
                <th class="p-2 text-center">Acciones</th>
            </tr>
            </thead>

            <tbody>
            @foreach($memberships as $membership)
            <tr x-data="{ editing: false }" class="border-t">
                <form method="POST" action="{{ route('admin.memberships.update', $membership) }}">
                    @csrf
                    @method('PUT')

                    <td class="p-2">
                        <span x-show="!editing">{{ $membership->name }}</span>
                        <input x-show="editing" name="name" value="{{ $membership->name }}" class="border px-2 py-1">
                    </td>

                    <td class="p-2 text-center">
                        <span x-show="!editing">${{ $membership->price }}</span>
                        <input x-show="editing" name="price" type="number" step="0.01"
                               value="{{ $membership->price }}" class="border px-2 py-1 w-24">
                    </td>

                    <td class="p-2 text-center">
                        <span x-show="!editing">{{ $membership->duration_days }} días</span>
                        <input x-show="editing" name="duration_days" type="number"
                               value="{{ $membership->duration_days }}" class="border px-2 py-1 w-20">
                    </td>

                    <td class="p-2 text-center">
                        <span x-show="!editing">{{ $membership->active ? 'Sí' : 'No' }}</span>
                        <select x-show="editing" name="active" class="border px-2 py-1">
                            <option value="1" @selected($membership->active)>Sí</option>
                            <option value="0" @selected(!$membership->active)>No</option>
                        </select>
                    </td>

                    <td class="p-2 text-center">
                        <div class="flex justify-center gap-2">
                            <button type="button" x-show="!editing" @click="editing=true"
                                    class="bg-blue-600 text-white w-8 h-8 rounded">✏️</button>
                            <button type="submit" x-show="editing"
                                    class="bg-green-600 text-white w-8 h-8 rounded">💾</button>
                            <button type="button" x-show="editing" @click="editing=false"
                                    class="bg-gray-500 text-white w-8 h-8 rounded">❌</button>
                        </div>
                    </td>
                </form>
            </tr>
            @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $memberships->links() }}
        </div>
    </div>
</x-app-layout>
