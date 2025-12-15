
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Galaxy Gym</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-indigo-700 to-indigo-900 text-white">

<div class="min-h-screen flex flex-col items-center justify-center px-6">

    {{-- Logo --}}
    <div class="mb-6">
        <x-application-logo class="h-40 w-auto fill-current text-white" />
    </div>

    {{-- Título --}}
    <h1 class="text-4xl font-bold mb-2">
        Galaxy Gym
    </h1>

    {{-- Subtítulo --}}
    <p class="text-indigo-200 mb-8 text-center max-w-md">
        bienvenido,accede a tu cuenta o regístrate para continuar
    </p>

    {{-- Botones --}}
    <div class="flex gap-4">

        <a href="{{ route('login') }}"
           class="px-6 py-3 rounded-md bg-white text-indigo-700
                  font-semibold hover:bg-indigo-100 transition">
            Iniciar sesión
        </a>

        <a href="{{ route('register') }}"
           class="px-6 py-3 rounded-md border border-white
                  font-semibold hover:bg-indigo-800 transition">
            Registrarse
        </a>

    </div>

</div>

</body>
</html>
