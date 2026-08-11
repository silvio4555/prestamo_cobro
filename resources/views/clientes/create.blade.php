<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Nuevo Cliente</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    <div class="max-w-3xl mx-auto py-10">

        <div class="bg-white rounded-xl shadow-lg">

            <div class="bg-blue-600 text-white px-6 py-4 rounded-t-xl">
                <h1 class="text-2xl font-bold">
                    Registrar Cliente
                </h1>
            </div>

            <form action="{{ route('clientes.store') }}" method="POST" class="p-6">

                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Nombre -->

                    <div class="md:col-span-2">

                        <label class="block mb-2 font-semibold">
                            Nombre completo
                        </label>

                        <input
                            type="text"
                            name="nombre"
                            value="{{ old('nombre') }}"
                            class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500"
                            required>

                        @error('nombre')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                    </div>

                    <!-- Documento -->

                    <div>

                        <label class="block mb-2 font-semibold">
                            Documento
                        </label>

                        <input
                            type="text"
                            name="documento"
                            value="{{ old('documento') }}"
                            class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500"
                            required>

                        @error('documento')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                    </div>

                    <!-- Teléfono -->

                    <div>

                        <label class="block mb-2 font-semibold">
                            Teléfono
                        </label>

                        <input
                            type="text"
                            name="telefono"
                            value="{{ old('telefono') }}"
                            class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500">

                    </div>

                    <!-- Dirección -->

                    <div class="md:col-span-2">

                        <label class="block mb-2 font-semibold">
                            Dirección
                        </label>

                        <input
                            type="text"
                            name="direccion"
                            value="{{ old('direccion') }}"
                            class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500">

                    </div>

                    <!-- Correo -->

                    <div class="md:col-span-2">

                        <label class="block mb-2 font-semibold">
                            Correo electrónico
                        </label>

                        <input
                            type="email"
                            name="correo"
                            value="{{ old('correo') }}"
                            class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500">

                    </div>

                </div>

                <div class="mt-8 flex justify-end gap-3">

                    <a href="{{ route('clientes.index') }}"
                        class="px-6 py-3 bg-gray-300 rounded-lg hover:bg-gray-400">

                        Cancelar

                    </a>

                    <button
                        type="submit"
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">

                        Guardar Cliente

                    </button>

                </div>

            </form>

        </div>

    </div>

</body>

</html>