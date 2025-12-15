<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Administración de Usuarios</h2>
    </x-slot>

    <div class="p-6">
        {{-- Mensaje de éxito tras operaciones CRUD --}}
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
                <th class="p-2 text-center">Rol</th>
                <th class="p-2 text-center">Activo</th>
                <th class="p-2 text-left">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
            <tr class="border-t" x-data="{ editing: false }">

                {{-- FORMULARIO INLINE (una fila = un form) --}}
                <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                    @csrf
                    @method('PUT')

                    {{-- Nombre --}}
                    <td class="p-2">
                        <span x-show="!editing">{{ $user->name }}</span>
                        <input x-show="editing"
                               type="text"
                               name="name"
                               value="{{ $user->name }}"
                               class="border rounded px-2 py-1 w-full">
                    </td>

                    {{-- Email --}}
                    <td class="p-2">
                        <span x-show="!editing">{{ $user->email }}</span>
                        <input x-show="editing"
                               type="email"
                               name="email"
                               value="{{ $user->email }}"
                               class="border rounded px-2 py-1 w-full">
                    </td>

                    {{-- Rol --}}
                    <td class="p-2 text-center">
                        <span x-show="!editing">{{ $user->role->name }}</span>
                        <select x-show="editing"
                                name="role_id"
                                class="border rounded px-2 py-1">
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}"
                                    @selected($user->role_id == $role->id)>
                                {{ $role->name }}
                            </option>
                            @endforeach
                        </select>
                    </td>

                    {{-- Activo --}}
                    <td class="p-2 text-center">
                        <span x-show="!editing">{{ $user->active ? 'Sí' : 'No' }}</span>
                        <select x-show="editing"
                                name="active"
                                class="border rounded px-2 py-1 w-full">
                            <option value="1" @selected($user->active)>Sí</option>
                            <option value="0" @selected(!$user->active)>No</option>
                        </select>
                    </td>

                    {{-- Acciones --}}
                    <td class="p-2 text-center">
                        <div class="flex gap-2">

                            {{-- Editar --}}
                            <button type="button"
                                    x-show="!editing"
                                    @click="editing = true"
                                    class="px-3 py-2 bg-blue-600 text-white rounded">
                                       ✏️ editar
                            </button>

                            {{-- Guardar --}}
                            <button type="submit"
                                    x-show="editing"
                                    class="px-3 py-2 bg-green-600 text-white rounded">
                                      💾 guardar
                            </button>

                            {{-- Cancelar --}}
                            <button type="button"
                                    x-show="editing"
                                    @click="editing = false"
                                    class="px-3 py-2 bg-gray-400 text-white rounded">
                                      ❌ eliminar
                            </button>

                        </div>
                    </td>
                </form>
            </tr>
            @endforeach
            </tbody>
        </table>

        {{-- Paginación --}}
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
