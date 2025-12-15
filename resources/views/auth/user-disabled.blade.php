<x-guest-layout>
    <div class="max-w-md mx-auto text-center">
        <h1 class="text-2xl font-bold text-red-600 mb-4">
            Cuenta desactivada
        </h1>

        <p class="text-gray-700 mb-6">
            Tu cuenta ha sido dada de baja por un administrador.
        </p>

        <p class="text-sm text-gray-500 mb-6">
            Si consideras que esto es un error, por favor contacta al personal del gimnasio.
        </p>

        <a href="{{ route('login') }}"
           class="inline-block px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-500">
            Volver al login
        </a>
    </div>
</x-guest-layout>
