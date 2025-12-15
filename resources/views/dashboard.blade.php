<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Vista General
        </h2>
    </x-slot>

    <div class="p-6 space-y-6">

        {{-- ========================= --}}
        {{-- DASHBOARD CLIENTE --}}
        {{-- ========================= --}}
        @if(auth()->user()->role->name === 'cliente')

        {{-- ========================= --}}
        {{-- BLOQUE: MI MEMBRESÍA --}}
        {{-- ========================= --}}
        <div class="bg-white shadow rounded p-6">
            <h3 class="text-lg font-semibold mb-4">
                Mi Membresía
            </h3>

            @if(auth()->user()->membership)

            <div class="space-y-2">
                <p>
                    <strong>Membresía:</strong>
                    {{ auth()->user()->membership->name }}
                </p>

                <p>
                    <strong>Inicio:</strong>
                    {{ auth()->user()->membership_start_date }}
                </p>

                <p>
                    <strong>Expiración:</strong>
                    {{ auth()->user()->membership_end_date }}
                </p>

                <p>
                    <strong>Estado:</strong>
                    @if(auth()->user()->membership_is_active)
                    <span class="text-green-600 font-semibold">Activa</span>
                    @else
                    <span class="text-red-600 font-semibold">Expirada</span>
                    @endif
                </p>
            </div>

            @else
            <p class="text-gray-600">
                No tienes una membresía asignada actualmente.
            </p>
            @endif
        </div>

        {{-- ========================= --}}
        {{-- BLOQUE: PROMOCIONES --}}
        {{-- ========================= --}}
        <div class="bg-white shadow rounded p-6">
            <h3 class="text-lg font-semibold mb-4">
                Promociones Disponibles
            </h3>

            @if(auth()->user()->membership)

            @php
            $today = now()->toDateString();

            $promotions = \App\Models\Promotion::where('active', true)
            ->where(function ($query) use ($today) {
            $query->whereNull('starts_at')
            ->orWhere('starts_at', '<=', $today);
            })
            ->where(function ($query) use ($today) {
            $query->whereNull('ends_at')
            ->orWhere('ends_at', '>=', $today);
            })
            ->where(function ($query) {
            $query->whereNull('membership_id')
            ->orWhere('membership_id', auth()->user()->membership->id);
            })
            ->get();
            @endphp

            @if($promotions->count())

            <ul class="space-y-3">
                @foreach($promotions as $promo)
                <li class="border rounded p-4">
                    <p class="font-semibold">
                        {{ $promo->name }}
                    </p>

                    <p class="text-sm text-gray-600">
                        {{ $promo->description }}
                    </p>

                    <p class="text-sm mt-1">
                        <strong>Descuento:</strong>
                        @if($promo->discount_type === 'percentage')
                        {{ $promo->discount_value }}%
                        @else
                        ${{ $promo->discount_value }}
                        @endif
                    </p>
                </li>
                @endforeach
            </ul>

            @else
            <p class="text-gray-600">
                No hay promociones activas para tu membresía.
            </p>
            @endif

            @else
            <p class="text-gray-600">
                Asigna una membresía para acceder a promociones.
            </p>
            @endif
        </div>

        {{-- ========================= --}}
        {{-- DASHBOARD ADMIN / RECEPCIONISTA --}}
        {{-- ========================= --}}
        @else

        <div class="bg-white shadow rounded p-6">
            <h3 class="text-lg font-semibold mb-4">
                Panel Administrativo
            </h3>

            <p class="text-gray-700">
                Usa el menú para gestionar usuarios, clientes, membresías y promociones.
            </p>
        </div>

        @endif

    </div>
</x-app-layout>
