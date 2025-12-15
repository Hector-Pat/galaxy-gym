<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Gestión de Clientes</h2>
    </x-slot>

    <div class="p-6">
        @if(session('success'))
        <div class="mb-4 text-green-600">
            {{ session('success') }}
        </div>
        @endif

        <table class="w-full border">
            <thead>
            <tr class="bg-gray-100">
                <th class="p-2 text-left">Nombre</th>
                <th class="p-2 text-left">Email</th>
                <th class="p-2 text-center">Membresía</th>
                <th class="p-2 text-center">Activo</th>
                <th class="p-2 text-center">Acciones</th>
            </tr>
            </thead>

            <tbody>
            @foreach($clients as $client)
            <tr class="border-t" x-data="{ editing: false }">

                <form method="POST" action="{{ route('admin.clients.update', $client->id) }}">
                    @csrf
                    @method('PUT')

                    {{-- Nombre --}}
                    <td class="p-2">
                        <span x-show="!editing">{{ $client->name }}</span>
                        <input x-show="editing"
                               type="text"
                               name="name"
                               value="{{ $client->name }}"
                               class="border rounded px-2 py-1 w-full">
                    </td>

                    {{-- Email --}}
                    <td class="p-2">
                        <span x-show="!editing">{{ $client->email }}</span>
                        <input x-show="editing"
                               type="email"
                               name="email"
                               value="{{ $client->email }}"
                               class="border rounded px-2 py-1 w-full">
                    </td>

                    {{-- Membresía --}}
                    <td class="p-2 text-center">
                        <span x-show="!editing">
                            {{ $client->membership->name ?? 'Sin membresía' }}
                        </span>

                        <select x-show="editing"
                                name="membership_id"
                                class="border rounded px-2 py-1">
                            <option value="">Sin membresía</option>
                            @foreach($memberships as $membership)
                            <option value="{{ $membership->id }}"
                                    @selected($client->membership_id == $membership->id)>
                                {{ $membership->name }}
                            </option>
                            @endforeach
                        </select>
                    </td>

                    {{-- Activo --}}
                    <td class="p-2 text-center">
                        <span x-show="!editing">{{ $client->active ? 'Sí' : 'No' }}</span>
                        <select x-show="editing"
                                name="active"
                                class="border rounded px-2 py-1">
                            <option value="1" @selected($client->active)>Sí</option>
                            <option value="0" @selected(!$client->active)>No</option>
                        </select>
                    </td>

                    {{-- Acciones --}}
                    <td class="p-2 text-center">
                        <div class="flex gap-2 justify-center">

                            <button type="button"
                                    x-show="!editing"
                                    @click="editing = true"
                                    class="px-3 py-2 bg-blue-600 text-white rounded">
                                ✏️ editar
                            </button>

                            <button type="submit"
                                    x-show="editing"
                                    class="px-3 py-2 bg-green-600 text-white rounded">
                                💾 guardar
                            </button>

                            <button type="button"
                                    x-show="editing"
                                    @click="editing = false"
                                    class="px-3 py-2 bg-gray-400 text-white rounded">
                                ❌ cancelar
                            </button>

                        </div>
                    </td>
                </form>
            </tr>
            @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $clients->links() }}
        </div>
    </div>
</x-app-layout>
