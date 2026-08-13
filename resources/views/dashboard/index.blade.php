<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard de cobros</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-100">

<div class="mx-auto max-w-7xl px-6 py-10">

    {{-- MENSAJE DE ÉXITO --}}
    @if(session('success'))

        <div class="mb-6 flex items-center gap-3 rounded-lg border border-green-300 bg-green-100 px-5 py-4 text-green-700">
            <span class="text-lg">✓</span>
            {{ session('success') }}
        </div>

    @endif


    {{-- ENCABEZADO --}}
    <div class="mb-8 overflow-hidden rounded-xl bg-blue-600 shadow-sm">

        <div class="flex flex-col gap-4 p-8 text-white sm:flex-row sm:items-center sm:justify-between">

            <div>

                <p class="text-sm font-medium text-blue-100">
                    {{ ucfirst($hoy->locale('es')->isoFormat('dddd, D [de] MMMM')) }}
                </p>

                <h1 class="mt-1 text-3xl font-bold">
                    Dashboard de cobros
                </h1>

                <p class="mt-1 text-blue-100">
                    Esto es lo que tienes por cobrar hoy
                </p>

            </div>

            <a
                href="{{ route('clientes.index') }}"
                class="inline-flex items-center gap-2 self-start rounded-lg bg-white px-5 py-3 font-semibold text-blue-700 shadow-sm transition hover:bg-blue-50"
            >
                👥 Ver clientes
            </a>

        </div>

    </div>


    {{-- TARJETAS RESUMEN --}}
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">

        <div class="flex items-start gap-4 rounded-xl border-l-4 border-blue-600 bg-white p-6 shadow-sm transition hover:shadow-md">

            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-blue-100 text-2xl">
                📅
            </div>

            <div>
                <p class="text-sm text-gray-500">Por cobrar hoy</p>

                <p class="mt-1 text-2xl font-bold text-blue-600">
                    ${{ number_format($totalHoy, 2, ',', '.') }}
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    {{ $cobrosHoy->count() }} {{ Str::plural('cuota', $cobrosHoy->count()) }}
                </p>
            </div>

        </div>

        <div class="flex items-start gap-4 rounded-xl border-l-4 border-red-600 bg-white p-6 shadow-sm transition hover:shadow-md">

            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 text-2xl">
                🔴
            </div>

            <div>
                <p class="text-sm text-gray-500">Vencido</p>

                <p class="mt-1 text-2xl font-bold text-red-600">
                    ${{ number_format($totalVencido, 2, ',', '.') }}
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    {{ $cobrosVencidos->count() }} {{ Str::plural('cuota', $cobrosVencidos->count()) }}
                </p>
            </div>

        </div>

        <div class="flex items-start gap-4 rounded-xl border-l-4 border-green-600 bg-white p-6 shadow-sm transition hover:shadow-md">

            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-green-100 text-2xl">
                💵
            </div>

            <div>
                <p class="text-sm text-gray-500">Cobrado hoy</p>

                <p class="mt-1 text-2xl font-bold text-green-600">
                    ${{ number_format($cobradoHoy, 2, ',', '.') }}
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    Pagos registrados hoy
                </p>
            </div>

        </div>

        <div class="flex items-start gap-4 rounded-xl border-l-4 border-gray-400 bg-white p-6 shadow-sm transition hover:shadow-md">

            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-gray-100 text-2xl">
                👤
            </div>

            <div>
                <p class="text-sm text-gray-500">Clientes por cobrar</p>

                <p class="mt-1 text-2xl font-bold text-gray-800">
                    {{ $clientesConDeuda->count() }}
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    Con cobros hoy o vencidos
                </p>
            </div>

        </div>

    </div>


    {{-- CLIENTES QUE DEBEN PAGAR --}}
    <div class="mt-8 overflow-hidden rounded-xl bg-white shadow-sm">

        <div class="flex items-center justify-between border-b border-gray-200 p-6">

            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    Clientes que deben pagar
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Clientes con cuotas por cobrar hoy o vencidas
                </p>
            </div>

            @if($clientesConDeuda->count() > 0)

                <span class="rounded-full bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700">
                    {{ $clientesConDeuda->count() }} {{ Str::plural('cliente', $clientesConDeuda->count()) }}
                </span>

            @endif

        </div>

        @if($clientesConDeuda->count() > 0)

            <div class="divide-y divide-gray-100">

                @foreach($clientesConDeuda as $item)

                    <div class="flex flex-col gap-4 p-6 transition hover:bg-gray-50 sm:flex-row sm:items-center sm:justify-between">

                        <div class="flex items-center gap-4">

                            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-blue-100 font-bold text-blue-700">
                                {{ strtoupper(substr($item->cliente->nombre, 0, 1)) }}
                            </div>

                            <div>

                                <div class="flex flex-wrap items-center gap-2">

                                    <p class="font-semibold text-gray-800">
                                        {{ $item->cliente->nombre }}
                                    </p>

                                    @if($item->tiene_vencidas)

                                        <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                            🔴 Tiene cuotas vencidas
                                        </span>

                                    @else

                                        <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                            🟢 Vence hoy
                                        </span>

                                    @endif

                                </div>

                                <p class="mt-1 text-sm text-gray-500">
                                    {{ $item->cliente->telefono ?: 'Sin teléfono registrado' }}
                                    &middot;
                                    {{ $item->cuotas->count() }} {{ Str::plural('cuota', $item->cuotas->count()) }} pendiente(s)
                                </p>

                            </div>

                        </div>

                        <div class="flex items-center gap-4 sm:pl-16">

                            <p class="text-xl font-bold text-gray-800">
                                ${{ number_format($item->total_adeudado, 2, ',', '.') }}
                            </p>

                            <a
                                href="{{ route('clientes.show', $item->cliente) }}"
                                class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700"
                            >
                                Ver cliente
                            </a>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="px-6 py-12 text-center">
                <div class="text-4xl">🎉</div>
                <p class="mt-3 text-gray-500">
                    No hay clientes con cobros pendientes por hoy.
                </p>
            </div>

        @endif

    </div>


    <div class="mt-8 grid gap-8 lg:grid-cols-2">

        {{-- COBROS DE HOY --}}
        <div class="overflow-hidden rounded-xl bg-white shadow-sm">

            <div class="flex items-center justify-between border-b border-gray-200 p-6">

                <h2 class="flex items-center gap-2 text-xl font-bold text-gray-800">
                    <span>📅</span> Cobros de hoy
                </h2>

                @if($cobrosHoy->count() > 0)
                    <span class="rounded-full bg-blue-50 px-3 py-1 text-sm font-semibold text-blue-700">
                        {{ $cobrosHoy->count() }}
                    </span>
                @endif

            </div>

            @if($cobrosHoy->count() > 0)

                <div class="divide-y divide-gray-100">

                    @foreach($cobrosHoy as $cuota)

                        <div class="flex items-center justify-between gap-3 border-l-4 border-blue-500 p-5 transition hover:bg-gray-50">

                            <div>

                                <p class="font-semibold text-gray-800">
                                    {{ $cuota->prestamo->cliente->nombre }}
                                </p>

                                <p class="text-sm text-gray-500">
                                    Préstamo #{{ $cuota->prestamo_id }} &middot; Cuota #{{ $cuota->numero_cuota }}
                                </p>

                            </div>

                            <div class="flex flex-shrink-0 items-center gap-3">

                                <p class="font-bold text-blue-600">
                                    ${{ number_format($cuota->saldo_pendiente, 2, ',', '.') }}
                                </p>

                                <a
                                    href="{{ route('cobros.create', $cuota) }}"
                                    class="rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700"
                                >
                                    Cobrar
                                </a>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="px-6 py-12 text-center">
                    <div class="text-4xl">📭</div>
                    <p class="mt-3 text-gray-500">
                        No hay cuotas programadas para hoy.
                    </p>
                </div>

            @endif

        </div>


        {{-- COBROS VENCIDOS --}}
        <div class="overflow-hidden rounded-xl bg-white shadow-sm">

            <div class="flex items-center justify-between border-b border-gray-200 p-6">

                <h2 class="flex items-center gap-2 text-xl font-bold text-gray-800">
                    <span>🔴</span> Cobros vencidos
                </h2>

                @if($cobrosVencidos->count() > 0)
                    <span class="rounded-full bg-red-50 px-3 py-1 text-sm font-semibold text-red-700">
                        {{ $cobrosVencidos->count() }}
                    </span>
                @endif

            </div>

            @if($cobrosVencidos->count() > 0)

                <div class="divide-y divide-gray-100">

                    @foreach($cobrosVencidos as $cuota)

                        @php
                            $diasPlazo = (int) ($cuota->prestamo->dias_plazo ?? 0);
                            $diasRetraso = $cuota->diasDesdeVencimiento() - $diasPlazo;
                        @endphp

                        <div class="flex items-center justify-between gap-3 border-l-4 border-red-500 bg-red-50/40 p-5 transition hover:bg-red-50">

                            <div>

                                <p class="font-semibold text-gray-800">
                                    {{ $cuota->prestamo->cliente->nombre }}
                                </p>

                                <p class="text-sm text-red-600">
                                    Préstamo #{{ $cuota->prestamo_id }} &middot; Cuota #{{ $cuota->numero_cuota }}
                                    &middot; {{ $diasRetraso }} {{ Str::plural('día', $diasRetraso) }} de retraso
                                </p>

                            </div>

                            <div class="flex flex-shrink-0 items-center gap-3">

                                <p class="font-bold text-red-600">
                                    ${{ number_format($cuota->saldo_pendiente, 2, ',', '.') }}
                                </p>

                                <a
                                    href="{{ route('cobros.create', $cuota) }}"
                                    class="rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700"
                                >
                                    Cobrar
                                </a>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="px-6 py-12 text-center">
                    <div class="text-4xl">🎉</div>
                    <p class="mt-3 text-gray-500">
                        No hay cuotas vencidas.
                    </p>
                </div>

            @endif

        </div>

    </div>

</div>

</body>

</html>