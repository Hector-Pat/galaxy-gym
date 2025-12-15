<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Gestión de Promociones</h2>
    </x-slot>

    <div class="p-6">
        @if(session('success'))
        <div class="mb-4 text-green-600">
            {{ session('success') }}
        </div>
        @endif

        <div class="mb-4">
            <a href="{{ route('admin.promotions.create') }}"
               class="px-4 py-2 bg-indigo-600 text-white rounded">
                ➕ Nueva promoción
            </a>
        </div>

        <table class="w-full border">
            <thead>
            <tr class="bg-gray-100">
                <th class="p-2">Nombre</th>
                <th class="p-2">Tipo</th>
                <th class="p-2">Valor</th>
                <th class="p-2">Membresía</th>
                <th class="p-2">Activo</th>
                <th class="p-2">Acciones</th>
            </tr>
            </thead>

            <tbody>
            @foreach($promotions as $promotion)
            <tr class="border-t text-center">
                <td class="p-2 text-left">{{ $promotion->name }}</td>

                <td class="p-2">
                    {{ $promotion->discount_type === 'percentage' ? '%' : '$' }}
                </td>

                <td class="p-2">
                    {{ $promotion->discount_value }}
                </td>

                <td class="p-2">
                    {{ $promotion->membership->name ?? 'Todas' }}
                </td>

                <td class="p-2">
                    {{ $promotion->active ? 'Sí' : 'No' }}
                </td>

                <td class="p-2 flex gap-2 justify-center">
                    <a href="{{ route('admin.promotions.edit', $promotion) }}"
                       class="px-3 py-1 bg-blue-600 text-white rounded">
                        ✏️ Editar
                    </a>

                    @if($promotion->active)
                    <form method="POST" action="{{ route('admin.promotions.destroy', $promotion) }}">
                        @csrf
                        @method('DELETE')
                        <button class="px-3 py-1 bg-red-600 text-white rounded">
                            ❌ Desactivar
                        </button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $promotions->links() }}
        </div>
    </div>
</x-app-layout>
