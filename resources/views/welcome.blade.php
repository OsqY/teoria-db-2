<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Librería</title>
    @vite('resources/css/app.css') {{-- Asegúrate de tener Vite funcionando --}}
    @filamentStyles
</head>
<body class="bg-gradient-to-br from-white to-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white p-10 rounded-2xl shadow-xl max-w-xl w-full text-center">
        <h1 class="text-4xl font-bold text-[#0A5784] mb-4">Sistema de Librería</h1>
        <p class="text-gray-700 text-lg mb-8">
            Bienvenido al sistema de gestión de libros, préstamos y usuarios.
        </p>

        <x-filament::button
            tag="a"
            href="{{ url('/admin') }}"
            color="primary"
            size="xl"
            icon="heroicon-o-cog-6-tooth"
            class="text-white bg-[#0A5784] hover:bg-[#084668] px-6 py-3 rounded-xl shadow-md transition"
        >
            Ir al Panel Administrativo
        </x-filament::button>
    </div>

    @filamentScripts
</body>
</html>

