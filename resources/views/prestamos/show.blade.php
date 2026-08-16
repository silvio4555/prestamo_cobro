<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detalle del préstamo</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-100">

<div class="mx-auto max-w-7xl px-6 py-10">

    {{-- MENSAJE DE ÉXITO --}}
    @if(session('success'))

        <div class="mb-6 rounded-lg border border-green-300 bg-green-100 px-5 py-4 text-green-700">
            {{ session('success') }}
        </div>

    @endif

    {{-- MENSAJE DE ERROR --}}
    @if(session('error'))

        <div class="mb-6 rounded-lg border border-red-300 bg-red-100 px-5 py-4 text-red-700">
            {{ session('error') }}
        </div>

    @endif


    {{-- ENCABEZADO --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>

            <a
                href="{{ route('clientes.show', $prestamo->cliente) }}"
                class="font-medium text-blue-600 hover:text-blue-800"
            >
                ← Volver al cliente
            </a>

            <h1 class="mt-3 text-3xl font-bold text-gray-800">
                Detalle del préstamo
            </h1>

            <p class="mt-1 text-gray-500">
                Información completa del préstamo
            </p>

        </div>

        <div class="flex gap-3">

            <a
                href="{{ route('prestamos.edit', $prestamo) }}"
                class="rounded-lg bg-blue-600 px-5 py-3 font-semibold text-white hover:bg-blue-700"
            >
                Editar
            </a>

        </div>

    </div>


    {{-- INFORMACIÓN DEL PRÉSTAMO --}}
    <div class="overflow-hidden rounded-xl bg-white shadow-sm">

        <div class="bg-blue-600 p-6 text-white">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div>

                    <h2 class="text-2xl font-bold">
                        Préstamo #{{ $prestamo->id }}
                    </h2>

                    <p class="mt-1">
                        Cliente:

                        <strong>
                            {{ $prestamo->cliente->nombre }}
                        </strong>
                    </p>

                </div>


                @if($prestamo->estado === 'activo')

                    <span class="rounded-full bg-green-500 px-4 py-2 font-semibold text-white">
                        Activo
                    </span>

                @elseif($prestamo->estado === 'pagado')

                    <span class="rounded-full bg-white px-4 py-2 font-semibold text-blue-700">
                        Pagado
                    </span>

                @elseif($prestamo->estado === 'vencido')

                    <span class="rounded-full bg-red-500 px-4 py-2 font-semibold text-white">
                        Vencido
                    </span>

                @else

                    <span class="rounded-full bg-gray-500 px-4 py-2 font-semibold text-white">
                        {{ ucfirst($prestamo->estado) }}
                    </span>

                @endif

            </div>

        </div>


        <div class="grid gap-6 p-6 md:grid-cols-3">

            {{-- MONTO --}}
            <div class="rounded-lg bg-gray-50 p-5">

                <p class="text-sm text-gray-500">
                    Monto prestado
                </p>

                <p class="mt-2 text-2xl font-bold text-gray-800">
                    ${{ number_format($prestamo->monto_prestado, 0, ',', '.') }}
                </p>

            </div>


            {{-- INTERÉS --}}
            <div class="rounded-lg bg-gray-50 p-5">

                <p class="text-sm text-gray-500">
                    Tasa de interés
                </p>

                <p class="mt-2 text-2xl font-bold text-gray-800">
                    {{ number_format($prestamo->tasa_interes, 2, ',', '.') }}%
                </p>

            </div>


            {{-- TOTAL --}}
            <div class="rounded-lg bg-gray-50 p-5">

                <p class="text-sm text-gray-500">
                    Total a pagar
                </p>

                <p class="mt-2 text-2xl font-bold text-green-600">
                    ${{ number_format($prestamo->total_pagar, 0, ',', '.') }}
                </p>

            </div>


            {{-- FRECUENCIA --}}
            <div class="rounded-lg bg-gray-50 p-5">

                <p class="text-sm text-gray-500">
                    Frecuencia de pago
                </p>

                <p class="mt-2 text-lg font-bold capitalize text-gray-800">
                    {{ $prestamo->frecuencia }}
                </p>

            </div>


            {{-- NÚMERO DE CUOTAS --}}
            <div class="rounded-lg bg-gray-50 p-5">

                <p class="text-sm text-gray-500">
                    Número de cuotas
                </p>

                <p class="mt-2 text-lg font-bold text-gray-800">
                    {{ $prestamo->numero_cuotas }}
                </p>

            </div>


            {{-- VALOR CUOTA --}}
            <div class="rounded-lg bg-gray-50 p-5">

                <p class="text-sm text-gray-500">
                    Valor de cada cuota
                </p>

                <p class="mt-2 text-lg font-bold text-blue-600">
                    ${{ number_format($prestamo->valor_cuota, 0, ',', '.') }}
                </p>

            </div>


            {{-- FECHA PRÉSTAMO --}}
            <div class="rounded-lg bg-gray-50 p-5">

                <p class="text-sm text-gray-500">
                    Fecha del préstamo
                </p>

                <p class="mt-2 font-semibold text-gray-800">
                    {{ $prestamo->fecha_prestamo?->format('d/m/Y') }}
                </p>

            </div>


            {{-- PRIMER PAGO --}}
            <div class="rounded-lg bg-gray-50 p-5">

                <p class="text-sm text-gray-500">
                    Primer pago
                </p>

                <p class="mt-2 font-semibold text-gray-800">
                    {{ $prestamo->fecha_primer_pago?->format('d/m/Y') }}
                </p>

            </div>


            {{-- OBSERVACIONES --}}
            <div class="rounded-lg bg-gray-50 p-5 md:col-span-3">

                <p class="text-sm text-gray-500">
                    Observaciones
                </p>

                <p class="mt-2 text-gray-800">
                    {{ $prestamo->observaciones ?: 'Sin observaciones.' }}
                </p>

            </div>

        </div>

    </div>


    {{-- RESUMEN FINANCIERO --}}
    <div class="mt-8 overflow-hidden rounded-xl bg-white shadow-sm">

        <div class="border-b border-gray-200 p-6">

            <h2 class="text-2xl font-bold text-gray-800">
                Resumen financiero
            </h2>

        </div>

        <div class="grid gap-6 p-6 md:grid-cols-3">

            <div class="rounded-lg bg-gray-50 p-5">
                <p class="text-sm text-gray-500">Total de intereses</p>
                <p class="mt-2 text-xl font-bold text-gray-800">
                    ${{ number_format($prestamo->total_interes, 0, ',', '.') }}
                </p>
            </div>

            <div class="rounded-lg bg-green-50 p-5">
                <p class="text-sm text-green-600">Total abonado</p>
                <p class="mt-2 text-xl font-bold text-green-700">
                    ${{ number_format($prestamo->total_abonado, 0, ',', '.') }}
                </p>
            </div>

            <div class="rounded-lg bg-orange-50 p-5">
                <p class="text-sm text-orange-600">Saldo pendiente</p>
                <p class="mt-2 text-xl font-bold text-orange-700">
                    ${{ number_format($prestamo->saldo_pendiente, 0, ',', '.') }}
                </p>
            </div>

        </div>

    </div>


    {{-- RESUMEN DE CUOTAS --}}
    <div class="mt-8 overflow-hidden rounded-xl bg-white shadow-sm">

        <div class="border-b border-gray-200 p-6">

            <h2 class="text-2xl font-bold text-gray-800">
                Resumen de cuotas
            </h2>

        </div>

        <div class="grid gap-6 p-6 md:grid-cols-4">

            <div class="rounded-lg bg-green-50 p-5 text-center">
                <p class="text-sm text-green-600">Pagadas</p>
                <p class="mt-2 text-3xl font-bold text-green-700">
                    {{ $prestamo->cuotas_pagadas }}
                </p>
            </div>

            <div class="rounded-lg bg-yellow-50 p-5 text-center">
                <p class="text-sm text-yellow-600">Parciales</p>
                <p class="mt-2 text-3xl font-bold text-yellow-700">
                    {{ $prestamo->cuotas_parciales }}
                </p>
            </div>

            <div class="rounded-lg bg-gray-50 p-5 text-center">
                <p class="text-sm text-gray-500">Pendientes</p>
                <p class="mt-2 text-3xl font-bold text-gray-700">
                    {{ $prestamo->cuotas_pendientes }}
                </p>
            </div>

            <div class="rounded-lg bg-red-50 p-5 text-center">
                <p class="text-sm text-red-600">Vencidas</p>
                <p class="mt-2 text-3xl font-bold text-red-700">
                    {{ $prestamo->cuotas_vencidas }}
                </p>
            </div>

        </div>

    </div>


    {{-- HISTORIAL DE PAGOS COMPLETO --}}
    <div class="mt-8 overflow-hidden rounded-xl bg-white shadow-sm">

        <div class="border-b border-gray-200 p-6">

            <h2 class="text-2xl font-bold text-gray-800">
                Historial de pagos completo
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Todos los pagos registrados en este préstamo, de la más reciente a la más antigua.
            </p>

        </div>

        @if($historialPagos->count() > 0)

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">
                                Fecha
                            </th>

                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">
                                Cuota
                            </th>

                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">
                                Capital
                            </th>

                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">
                                Interés
                            </th>

                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">
                                Total
                            </th>

                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">
                                Método
                            </th>

                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">
                                Observación
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-200">

                        @foreach($historialPagos as $aplicacion)

                            <tr class="hover:bg-gray-50">

                                <td class="px-6 py-4 text-gray-700">
                                    {{ $aplicacion->pago?->fecha_pago?->format('d/m/Y') }}
                                </td>

                                <td class="px-6 py-4 text-gray-700">
                                    #{{ $aplicacion->cuota->numero_cuota }}
                                </td>

                                <td class="px-6 py-4 font-medium text-gray-800">
                                    ${{ number_format($aplicacion->monto_capital ?? 0, 0, ',', '.') }}
                                </td>

                                <td class="px-6 py-4 font-medium text-gray-800">
                                    ${{ number_format($aplicacion->monto_interes ?? 0, 0, ',', '.') }}
                                </td>

                                <td class="px-6 py-4 font-bold text-green-600">
                                    ${{ number_format(
                                        ($aplicacion->monto_capital ?? 0) +
                                        ($aplicacion->monto_interes ?? 0),
                                        0,
                                        ',',
                                        '.'
                                    ) }}
                                </td>

                                <td class="px-6 py-4 text-gray-600">
                                    {{ ucfirst($aplicacion->pago?->metodo_pago ?? 'N/A') }}
                                </td>

                                <td class="px-6 py-4 text-gray-600">
                                    {{ $aplicacion->pago?->observaciones ?: '—' }}
                                </td>

                            </tr>

                        @endforeach

                        <tr class="bg-gray-50 font-bold">

                            <td class="px-6 py-4 text-gray-700" colspan="2">
                                Total pagado
                            </td>

                            <td class="px-6 py-4 text-gray-800">
                                ${{ number_format($historialPagos->sum('monto_capital'), 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-4 text-gray-800">
                                ${{ number_format($historialPagos->sum('monto_interes'), 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-4 text-green-700">
                                ${{ number_format($historialPagos->sum('monto_capital') + $historialPagos->sum('monto_interes'), 0, ',', '.') }}
                            </td>

                            <td colspan="2"></td>

                        </tr>

                    </tbody>

                </table>

            </div>

        @else

            <div class="px-6 py-8 text-center text-gray-500">
                Todavía no hay pagos registrados en este préstamo.
            </div>

        @endif

    </div>


    {{-- CUOTAS --}}
    <div class="mt-8 overflow-hidden rounded-xl bg-white shadow-sm">

        <div class="border-b border-gray-200 p-6">

            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                <div>

                    <h2 class="text-2xl font-bold text-gray-800">
                        Cuotas del préstamo
                    </h2>

                    <p class="text-sm text-gray-500">
                        Control de pagos, abonos y saldos pendientes
                    </p>

                </div>


                <div class="rounded-lg bg-blue-50 px-4 py-2">

                    <span class="text-sm text-gray-500">
                        Total cuotas:
                    </span>

                    <strong class="text-blue-700">
                        {{ $prestamo->cuotas->count() }}
                    </strong>

                </div>

            </div>

        </div>


        {{-- LISTADO DE CUOTAS --}}
        <div class="space-y-6 p-6">

            @forelse($prestamo->cuotas as $cuota)

                <div class="overflow-hidden rounded-xl border border-gray-200">

                    {{-- CABECERA DE CUOTA --}}
                    <div class="bg-gray-50 px-6 py-5">

                        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                            <div>

                                <h3 class="text-xl font-bold text-gray-800">
                                    Cuota #{{ $cuota->numero_cuota }}
                                </h3>

                                <p class="mt-1 text-sm text-gray-500">
                                    Vencimiento:
                                    {{ $cuota->fecha_vencimiento?->format('d/m/Y') }}
                                </p>

                            </div>


                            {{-- ESTADO --}}
                            <div>

                                @php
                                    // Solo calculamos en vivo para cuotas todavía abiertas.
                                    $diasDesdeVencimiento = in_array($cuota->estado, ['pendiente', 'parcial'])
                                        ? $cuota->diasDesdeVencimiento()
                                        : null;

                                    $diasPlazo = (int) $prestamo->dias_plazo;
                                @endphp

                                @if($cuota->estado === 'pagada')

                                    <span class="rounded-full bg-green-100 px-4 py-2 text-sm font-semibold text-green-700">
                                        Pagada
                                    </span>

                                @elseif($cuota->estado === 'vencida')

                                    <span class="rounded-full bg-red-100 px-4 py-2 text-sm font-semibold text-red-700">
                                        🔴 Vencida
                                        @if($cuota->dias_retraso > 0)
                                            — {{ $cuota->dias_retraso }} {{ Str::plural('día', $cuota->dias_retraso) }} de retraso
                                        @endif
                                    </span>

                                @elseif($diasDesdeVencimiento !== null && $diasDesdeVencimiento > $diasPlazo)

                                    {{-- Ya pasó el plazo de gracia pero el comando todavía no la marcó vencida --}}
                                    <span class="rounded-full bg-red-100 px-4 py-2 text-sm font-semibold text-red-700">
                                        🔴 Vencida
                                        — {{ $diasDesdeVencimiento - $diasPlazo }} {{ Str::plural('día', $diasDesdeVencimiento - $diasPlazo) }} de retraso
                                    </span>

                                @elseif($diasDesdeVencimiento !== null && $diasDesdeVencimiento >= 1)

                                    <span class="rounded-full bg-green-100 px-4 py-2 text-sm font-semibold text-green-700">
                                        🟢 En plazo — {{ $diasDesdeVencimiento }} {{ Str::plural('día', $diasDesdeVencimiento) }}
                                    </span>

                                @elseif($diasDesdeVencimiento === 0)

                                    <span class="rounded-full bg-green-100 px-4 py-2 text-sm font-semibold text-green-700">
                                        🟢 Vence hoy
                                    </span>

                                @elseif($cuota->estado === 'parcial')

                                    <span class="rounded-full bg-orange-100 px-4 py-2 text-sm font-semibold text-orange-700">
                                        Pago parcial
                                    </span>

                                @else

                                    <span class="rounded-full bg-yellow-100 px-4 py-2 text-sm font-semibold text-yellow-700">
                                        Pendiente
                                    </span>

                                @endif

                            </div>

                        </div>

                    </div>


                    {{-- RESUMEN DE LA CUOTA --}}
                    <div class="grid gap-4 p-6 md:grid-cols-4">

                        {{-- VALOR PROGRAMADO --}}
                        <div class="rounded-lg bg-blue-50 p-4">

                            <p class="text-sm text-blue-600">
                                Valor programado
                            </p>

                            <p class="mt-1 text-xl font-bold text-blue-700">
                                ${{ number_format($cuota->valor_programado, 0, ',', '.') }}
                            </p>

                        </div>


                        {{-- CAPITAL --}}
                        <div class="rounded-lg bg-gray-50 p-4">

                            <p class="text-sm text-gray-500">
                                Saldo capital
                            </p>

                            <p class="mt-1 text-xl font-bold text-gray-800">
                                ${{ number_format($cuota->saldo_capital, 0, ',', '.') }}
                            </p>

                        </div>


                        {{-- INTERÉS --}}
                        <div class="rounded-lg bg-gray-50 p-4">

                            <p class="text-sm text-gray-500">
                                Saldo interés
                            </p>

                            <p class="mt-1 text-xl font-bold text-gray-800">
                                ${{ number_format($cuota->saldo_interes, 0, ',', '.') }}
                            </p>

                        </div>


                        {{-- SALDO TOTAL --}}
                        <div class="rounded-lg bg-orange-50 p-4">

                            <p class="text-sm text-orange-600">
                                Saldo pendiente
                            </p>

                            <p class="mt-1 text-xl font-bold text-orange-700">
                                ${{ number_format($cuota->saldo_pendiente, 0, ',', '.') }}
                            </p>

                        </div>

                    </div>


                    {{-- PAGOS DE LA CUOTA --}}
                    <div class="border-t border-gray-200">

                        <div class="px-6 py-5">

                            <h4 class="text-lg font-bold text-gray-800">
                                Historial de abonos
                            </h4>

                            <p class="mt-1 text-sm text-gray-500">
                                Todos los pagos registrados para esta cuota.
                            </p>

                        </div>


                        @if($cuota->aplicacionesPagos->count() > 0)

                            <div class="overflow-x-auto">

                                <table class="w-full">

                                    <thead class="bg-gray-50">

                                        <tr>

                                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">
                                                Fecha
                                            </th>

                                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">
                                                Capital
                                            </th>

                                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">
                                                Interés
                                            </th>

                                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">
                                                Total
                                            </th>

                                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">
                                                Método
                                            </th>

                                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">
                                                Observaciones
                                            </th>

                                        </tr>

                                    </thead>


                                    <tbody class="divide-y divide-gray-200">

                                        @foreach($cuota->aplicacionesPagos as $aplicacion)

                                            <tr class="hover:bg-gray-50">

                                                <td class="px-6 py-4 text-gray-700">

                                                    {{ $aplicacion->pago?->fecha_pago?->format('d/m/Y') }}

                                                </td>


                                                <td class="px-6 py-4 font-medium text-gray-800">

                                                    ${{ number_format($aplicacion->monto_capital ?? 0, 0, ',', '.') }}

                                                </td>


                                                <td class="px-6 py-4 font-medium text-gray-800">

                                                    ${{ number_format($aplicacion->monto_interes ?? 0, 0, ',', '.') }}

                                                </td>


                                                <td class="px-6 py-4 font-bold text-green-600">

                                                    ${{ number_format(
                                                        ($aplicacion->monto_capital ?? 0) +
                                                        ($aplicacion->monto_interes ?? 0),
                                                        0,
                                                        ',',
                                                        '.'
                                                    ) }}

                                                </td>


                                                <td class="px-6 py-4 text-gray-600">

                                                    {{ ucfirst($aplicacion->pago?->metodo_pago ?? 'N/A') }}

                                                </td>


                                                <td class="px-6 py-4 text-gray-600">

                                                    {{ $aplicacion->pago?->observaciones ?: '—' }}

                                                </td>

                                            </tr>

                                        @endforeach

                                    </tbody>

                                </table>

                            </div>

                        @else

                            <div class="border-t border-gray-100 px-6 py-8 text-center">

                                <p class="text-gray-500">
                                    Todavía no hay abonos registrados para esta cuota.
                                </p>

                            </div>

                        @endif


                        {{-- BOTÓN DE PAGO --}}
                        <div class="flex justify-end border-t border-gray-200 bg-gray-50 px-6 py-4">

                            @if((float) $cuota->saldo_pendiente > 0)

                                <a
                                    href="{{ route('cobros.create', $cuota) }}"
                                    class="rounded-lg bg-green-600 px-5 py-3 font-semibold text-white shadow hover:bg-green-700"
                                >
                                    + Registrar pago
                                </a>

                            @else

                                <span class="rounded-lg bg-green-100 px-5 py-3 font-semibold text-green-700">
                                    ✓ Cuota completamente pagada
                                </span>

                            @endif

                        </div>

                    </div>

                </div>

            @empty

                <div class="py-12 text-center text-gray-500">

                    Este préstamo todavía no tiene cuotas.

                </div>

            @endforelse

        </div>

    </div>


    {{-- BOTÓN VOLVER --}}
    <div class="mt-8">

        <a
            href="{{ route('clientes.show', $prestamo->cliente) }}"
            class="inline-block rounded-lg bg-gray-600 px-6 py-3 font-semibold text-white hover:bg-gray-700"
        >
            ← Volver al cliente
        </a>

    </div>

</div>

</body>

</html>