<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar préstamo</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

<div class="mx-auto max-w-3xl px-4 py-10">


    {{-- ENCABEZADO --}}

    <div class="mb-8">

        <a
            href="{{ route('prestamos.show', $prestamo) }}"
            class="font-medium text-blue-600 hover:text-blue-800"
        >
            ← Volver al préstamo
        </a>

        <h1 class="mt-3 text-3xl font-bold text-gray-800">
            Editar préstamo #{{ $prestamo->id }}
        </h1>

        <p class="mt-2 text-gray-500">
            Cliente:
            <span class="font-semibold text-gray-700">
                {{ $prestamo->cliente->nombre }}
            </span>
        </p>

    </div>


    {{-- MENSAJES DE ERROR --}}

    @if ($errors->any())

        <div class="mb-6 rounded-lg border border-red-300 bg-red-100 px-5 py-4 text-red-700">

            <p class="font-semibold">
                Hay errores en el formulario:
            </p>

            <ul class="mt-2 list-inside list-disc">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    {{-- AVISO --}}

    <div class="mb-6 rounded-lg border border-blue-200 bg-blue-50 px-5 py-4 text-sm text-blue-700">
        Solo puedes editar el <strong>estado</strong> y las <strong>observaciones</strong> del préstamo.
        El monto, la tasa, las cuotas y las fechas no se pueden modificar porque ya generaron el
        plan de pagos del cliente.
    </div>


    {{-- FORMULARIO --}}

    <form
        method="POST"
        action="{{ route('prestamos.update', $prestamo) }}"
        class="space-y-6 rounded-xl bg-white p-8 shadow-sm"
    >
        @csrf
        @method('PUT')


        {{-- INFORMACIÓN DE SOLO LECTURA --}}

        <div class="grid grid-cols-2 gap-4 rounded-lg bg-gray-50 p-5 sm:grid-cols-4">

            <div>
                <p class="text-xs text-gray-500">Monto prestado</p>
                <p class="mt-1 font-semibold text-gray-800">
                    ${{ number_format($prestamo->monto_prestado, 0, ',', '.') }}
                </p>
            </div>

            <div>
                <p class="text-xs text-gray-500">Tasa de interés</p>
                <p class="mt-1 font-semibold text-gray-800">
                    {{ number_format($prestamo->tasa_interes, 2, ',', '.') }}%
                </p>
            </div>

            <div>
                <p class="text-xs text-gray-500">Frecuencia</p>
                <p class="mt-1 font-semibold capitalize text-gray-800">
                    {{ $prestamo->frecuencia }}
                </p>
            </div>

            <div>
                <p class="text-xs text-gray-500">N.º de cuotas</p>
                <p class="mt-1 font-semibold text-gray-800">
                    {{ $prestamo->numero_cuotas }}
                </p>
            </div>

        </div>


        {{-- ESTADO --}}

        <div>

            <label class="mb-2 block text-sm font-semibold text-gray-700">
                Estado del préstamo
            </label>

            <select
                name="estado"
                class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
            >
                @foreach (['activo' => 'Activo', 'pagado' => 'Pagado', 'vencido' => 'Vencido', 'cancelado' => 'Cancelado'] as $valor => $etiqueta)
                    <option
                        value="{{ $valor }}"
                        {{ old('estado', $prestamo->estado) === $valor ? 'selected' : '' }}
                    >
                        {{ $etiqueta }}
                    </option>
                @endforeach
            </select>

        </div>


        {{-- OBSERVACIONES --}}

        <div>

            <label class="mb-2 block text-sm font-semibold text-gray-700">
                Observaciones
            </label>

            <textarea
                name="observaciones"
                rows="4"
                placeholder="Notas adicionales sobre este préstamo (opcional)"
                class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
            >{{ old('observaciones', $prestamo->observaciones) }}</textarea>

        </div>


        {{-- BOTONES --}}

        <div class="flex justify-end gap-3 border-t border-gray-100 pt-6">

            <a
                href="{{ route('prestamos.show', $prestamo) }}"
                class="rounded-lg border border-gray-300 px-6 py-3 font-semibold text-gray-700 hover:bg-gray-50"
            >
                Cancelar
            </a>

            <button
                type="submit"
                class="rounded-lg bg-blue-600 px-6 py-3 font-semibold text-white hover:bg-blue-700"
            >
                Guardar cambios
            </button>

        </div>

    </form>

</div>

</body>

</html>