<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Nuevo Gasto</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    <div class="max-w-2xl mx-auto py-10 px-4">

        <a href="{{ route('gastos.index') }}"
           class="inline-flex items-center gap-2 text-gray-500 hover:text-blue-600 mb-6">

            ← Volver a gastos

        </a>

        <div class="bg-white rounded-xl shadow-lg">

            <div class="bg-blue-600 text-white px-6 py-4 rounded-t-xl">
                <h1 class="text-2xl font-bold">
                    Registrar Gasto
                </h1>
            </div>

            <form action="{{ route('gastos.store') }}" method="POST" class="p-6">

                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Fecha -->

                    <div>

                        <label class="block mb-2 font-semibold">
                            Fecha
                        </label>

                        <input
                            type="date"
                            name="fecha"
                            value="{{ old('fecha', now()->format('Y-m-d')) }}"
                            class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500"
                            required>

                        @error('fecha')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                    </div>

                    <!-- Categoría -->

                    <div>

                        <label class="block mb-2 font-semibold">
                            Categoría
                        </label>

                        <select
                            name="categoria"
                            class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500"
                            required>

                            <option value="">Selecciona una categoría</option>

                            @foreach(\App\Models\Gasto::CATEGORIAS as $valor => $etiqueta)

                                <option
                                    value="{{ $valor }}"
                                    @selected(old('categoria') === $valor)
                                >
                                    {{ $etiqueta }}
                                </option>

                            @endforeach

                        </select>

                        @error('categoria')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                    </div>

                    <!-- Monto -->

                    <div class="md:col-span-2">

                        <label class="block mb-2 font-semibold">
                            Monto
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            min="0.01"
                            name="monto"
                            value="{{ old('monto') }}"
                            class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500"
                            required>

                        @error('monto')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                    </div>

                    <!-- Descripción -->

                    <div class="md:col-span-2">

                        <label class="block mb-2 font-semibold">
                            Descripción (opcional)
                        </label>

                        <input
                            type="text"
                            name="descripcion"
                            value="{{ old('descripcion') }}"
                            placeholder="Ej: Pago semanal, tanqueada moto, etc."
                            class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500">

                        @error('descripcion')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                    </div>

                </div>

                <div class="mt-8 flex justify-end gap-3">

                    <a href="{{ route('gastos.index') }}"
                        class="px-6 py-3 bg-gray-300 rounded-lg hover:bg-gray-400">

                        Cancelar

                    </a>

                    <button
                        type="submit"
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">

                        Guardar Gasto

                    </button>

                </div>

            </form>

        </div>

    </div>

</body>

</html>