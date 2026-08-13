<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detalle del Cliente</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="min-h-screen bg-gray-100">

<div class="mx-auto max-w-7xl px-6 py-10">


    {{-- MENSAJE --}}
    @if(session('success'))

        <div class="mb-6 rounded-lg border border-green-300 bg-green-100 px-5 py-4 text-green-700">
            {{ session('success') }}
        </div>

    @endif


    {{-- INFORMACIÓN DEL CLIENTE --}}
    <div class="overflow-hidden rounded-xl bg-white shadow-lg">

        {{-- ENCABEZADO --}}
        <div class="flex items-center justify-between bg-blue-600 px-8 py-6 text-white">

            <div>

                <h1 class="text-3xl font-bold">
                    {{ $cliente->nombre }}
                </h1>

                <p class="mt-1 text-blue-100">
                    Información del cliente
                </p>

            </div>


            @if($cliente->estado === 'activo')

                <span class="rounded-full bg-white px-4 py-2 font-semibold text-green-700">
                    Activo
                </span>

            @else

                <span class="rounded-full bg-white px-4 py-2 font-semibold text-red-600">
                    Inactivo
                </span>

            @endif

        </div>


        {{-- DATOS DEL CLIENTE --}}
        <div class="grid gap-6 p-8 md:grid-cols-2">

            <div>

                <p class="font-semibold text-gray-700">
                    Documento
                </p>

                <p class="mt-1 text-gray-600">
                    {{ $cliente->documento }}
                </p>

            </div>


            <div>

                <p class="font-semibold text-gray-700">
                    Teléfono
                </p>

                <p class="mt-1 text-gray-600">
                    {{ $cliente->telefono ?: 'No registrado' }}
                </p>

            </div>


            <div>

                <p class="font-semibold text-gray-700">
                    Correo
                </p>

                <p class="mt-1 text-gray-600">
                    {{ $cliente->correo ?: 'No registrado' }}
                </p>

            </div>


            <div>

                <p class="font-semibold text-gray-700">
                    Dirección
                </p>

                <p class="mt-1 text-gray-600">
                    {{ $cliente->direccion ?: 'No registrada' }}
                </p>

            </div>

        </div>

    </div>


    {{-- PRÉSTAMOS --}}
    <div class="mt-8 overflow-hidden rounded-xl bg-white shadow-lg">

        {{-- CABECERA --}}
        <div class="flex items-center justify-between border-b border-gray-200 p-6">

            <div>

                <h2 class="text-2xl font-bold text-gray-800">
                    Préstamos
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Préstamos registrados para este cliente
                </p>

            </div>


            {{-- NUEVO PRÉSTAMO --}}
            <a
                href="{{ route('prestamos.create', $cliente) }}"
                class="inline-flex items-center rounded-lg bg-green-600 px-5 py-3 font-semibold text-white shadow-sm transition hover:bg-green-700"
            >
                + Nuevo préstamo
            </a>

        </div>


        {{-- TABLA --}}
        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-gray-50">

                    <tr>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                            Monto
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                            Interés
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                            Total
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                            Cuotas
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                            Estado
                        </th>

                        <th class="px-6 py-4 text-center text-sm font-semibold text-gray-600">
                            Acciones
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-200">

                    @forelse($cliente->prestamos as $prestamo)

                        <tr class="transition hover:bg-gray-50">


                            {{-- MONTO --}}
                            <td class="px-6 py-4 font-medium text-gray-800">

                                ${{ number_format(
                                    (float) $prestamo->monto_prestado,
                                    2,
                                    ',',
                                    '.'
                                ) }}

                            </td>


                            {{-- INTERÉS --}}
                            <td class="px-6 py-4 font-semibold text-orange-600">

                                {{ number_format(
                                    (float) $prestamo->tasa_interes,
                                    2,
                                    ',',
                                    '.'
                                ) }}%

                            </td>


                            {{-- TOTAL --}}
                            <td class="px-6 py-4 font-medium text-gray-800">

                                ${{ number_format(
                                    (float) $prestamo->total_pagar,
                                    2,
                                    ',',
                                    '.'
                                ) }}

                            </td>


                            {{-- CUOTAS --}}
                            <td class="px-6 py-4 text-gray-600">

                                {{ $prestamo->numero_cuotas }}

                            </td>


                            {{-- ESTADO --}}
                            <td class="px-6 py-4">

                                @if($prestamo->estado === 'activo')

                                    <span class="rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-700">
                                        Activo
                                    </span>

                                @elseif($prestamo->estado === 'pagado')

                                    <span class="rounded-full bg-blue-100 px-3 py-1 text-sm font-medium text-blue-700">
                                        Pagado
                                    </span>

                                @else

                                    <span class="rounded-full bg-gray-100 px-3 py-1 text-sm font-medium text-gray-600">
                                        {{ ucfirst($prestamo->estado) }}
                                    </span>

                                @endif

                            </td>


                            {{-- ACCIONES --}}
                            <td class="px-6 py-4 text-center">

                                <a
                                    href="{{ route('prestamos.show', $prestamo) }}"
                                    class="inline-block rounded-lg bg-blue-600 px-4 py-2 font-medium text-white transition hover:bg-blue-700"
                                >
                                    Ver préstamo
                                </a>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="px-6 py-12 text-center"
                            >

                                <div class="text-4xl">
                                    💰
                                </div>

                                <p class="mt-3 text-gray-500">
                                    Este cliente aún no tiene préstamos registrados.
                                </p>

                                <a
                                    href="{{ route('prestamos.create', $cliente) }}"
                                    class="mt-4 inline-block font-medium text-green-600 hover:text-green-700"
                                >
                                    Registrar el primer préstamo
                                </a>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- BOTONES --}}
    <div class="mt-8 flex gap-3">

        <a
            href="{{ route('dashboard.index') }}"
            class="rounded-lg bg-blue-600 px-6 py-3 font-semibold text-white transition hover:bg-blue-700"
        >
            ← Volver al dashboard
        </a>

        <a
            href="{{ route('clientes.index') }}"
            class="rounded-lg bg-gray-600 px-6 py-3 font-semibold text-white transition hover:bg-gray-700"
        >
            ← Volver a clientes
        </a>


        <a
            href="{{ route('clientes.edit', $cliente) }}"
            class="rounded-lg bg-yellow-500 px-6 py-3 font-semibold text-white transition hover:bg-yellow-600"
        >
            ✏ Editar cliente
        </a>

    </div>


</div>

</body>

</html>