<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Asignar Membresía a Cliente</h2>
    </x-slot>

    <div class="p-6 max-w-xl">
        <form method="POST" action="{{ route('admin.memberships.assign.store') }}">
            @csrf

            {{-- Cliente --}}
            <div class="mb-4">
                <label class="block mb-1 font-medium">Cliente</label>
                <select name="user_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">Seleccione un cliente</option>
                    @foreach($clients as $client)
                    <option value="{{ $client->id }}">
                        {{ $client->name }} ({{ $client->email }})
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Membresía --}}
            <div class="mb-4">
                <label class="block mb-1 font-medium">Membresía</label>
                <select name="membership_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">Seleccione una membresía</option>
                    @foreach($memberships as $membership)
                    <option value="{{ $membership->id }}">
                        {{ $membership->name }} —
                        {{ $membership->duration_days }} días —
                        ${{ $membership->price }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Fecha inicio --}}
            <div class="mb-6">
                <label class="block mb-1 font-medium">Fecha de inicio</label>
                <input type="date"
                       name="start_date"
                       value="{{ now()->toDateString() }}"
                       class="w-full border rounded px-3 py-2"
                       required>
            </div>

            {{-- Acción --}}
            <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Asignar Membresía
            </button>
        </form>
    </div>
</x-app-layout>
