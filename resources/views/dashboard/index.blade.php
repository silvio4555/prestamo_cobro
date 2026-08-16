<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard de cobros</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-100">

<div class="flex min-h-screen">

    <!-- ========================================= -->
    <!-- MENÚ LATERAL -->
    <!-- ========================================= -->

    <aside class="flex w-64 flex-col bg-slate-900 text-white">

        <!-- Logo -->
        <div class="flex h-20 items-center border-b border-slate-700 px-6">

            <div class="flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-600 text-xl">
                    💰
                </div>

                <div>
                    <h1 class="text-lg font-bold">Préstamos</h1>
                    <p class="text-xs text-slate-400">Sistema de cobros</p>
                </div>

            </div>

        </div>

        <!-- Navegación -->
        <nav class="flex-1 space-y-2 p-4">

            <a
                href="{{ route('dashboard.index') }}"
                class="flex items-center gap-3 rounded-lg bg-blue-600 px-4 py-3 font-medium text-white transition"
            >
                <span>🏠</span>
                <span>Dashboard</span>
            </a>

            <a
                href="{{ route('clientes.index') }}"
                class="flex items-center gap-3 rounded-lg px-4 py-3 text-slate-300 transition hover:bg-slate-800 hover:text-white"
            >
                <span>👥</span>
                <span>Clientes</span>
            </a>

            <a
                href="{{ route('contabilidad.index') }}"
                class="flex items-center gap-3 rounded-lg px-4 py-3 text-slate-300 transition hover:bg-slate-800 hover:text-white"
            >
                <span>🧮</span>
                <span>Contabilidad</span>
            </a>

            <a
                href="{{ route('estadisticas.index') }}"
                class="flex items-center gap-3 rounded-lg px-4 py-3 text-slate-300 transition hover:bg-slate-800 hover:text-white"
            >
                <span>📊</span>
                <span>Estadísticas</span>
            </a>

        </nav>

        <!-- Parte inferior -->
        <div class="border-t border-slate-700 p-4">

            <a
                href="#"
                class="flex items-center gap-3 rounded-lg px-4 py-3 text-slate-300 transition hover:bg-slate-800 hover:text-white"
            >
                <span>⚙️</span>
                <span>Configuración</span>
            </a>

        </div>

    </aside>


    <!-- ========================================= -->
    <!-- CONTENIDO PRINCIPAL -->
    <!-- ========================================= -->

    <div class="flex flex-1 flex-col">

        <!-- HEADER -->
        <header class="flex h-20 items-center justify-between border-b border-gray-200 bg-white px-8">

            <h2 class="text-xl font-semibold text-gray-800">
                Dashboard
            </h2>

            <div class="flex items-center gap-3">

                <div class="text-right">
                    <p class="text-sm font-semibold text-gray-700">Administrador</p>
                    <p class="text-xs text-gray-500">Usuario principal</p>
                </div>

                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 font-bold text-blue-700">
                    A
                </div>

            </div>

        </header>


        <!-- CONTENIDO -->
        <main class="flex-1 overflow-y-auto p-8">

            {{-- MENSAJE DE ÉXITO --}}
            @if(session('success'))

                <div class="mb-6 flex items-center gap-3 rounded-lg border border-green-300 bg-green-100 px-5 py-4 text-green-700">
                    <span class="text-lg">✓</span>
                    {{ session('success') }}
                </div>

            @endif


            {{-- VISTA GENERAL --}}
            <div class="mb-8 flex flex-col gap-4 rounded-xl bg-white p-6 shadow-sm sm:flex-row sm:items-center sm:justify-between">

                <div class="flex items-center gap-4">

                    <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-lg bg-blue-600 text-2xl text-white">
                        📊
                    </div>

                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">
                            Vista general
                        </h1>

                        <p class="text-sm text-gray-500">
                            Resumen de cobros en tiempo real
                        </p>
                    </div>

                </div>

                <div class="rounded-lg bg-gray-100 px-4 py-2 text-sm text-gray-600">
                    Hoy:
                    <span class="font-semibold text-gray-800">
                        {{ ucfirst($hoy->locale('es')->isoFormat('dddd, D [de] MMMM')) }}
                    </span>
                </div>

            </div>


            {{-- TARJETAS RESUMEN --}}
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">

                <div class="overflow-hidden rounded-xl bg-white shadow-sm transition hover:shadow-md">

                    <div class="p-6">

                        <div class="flex items-start justify-between">
                            <p class="text-sm text-gray-500">Por cobrar hoy</p>

                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 text-lg">
                                📅
                            </div>
                        </div>

                        <p class="mt-3 text-2xl font-bold text-gray-800">
                            ${{ number_format($totalHoy, 0, ',', '.') }}
                        </p>

                        <p class="mt-1 text-sm text-gray-500">
                            {{ $cobrosHoy->count() }} {{ Str::plural('cuota', $cobrosHoy->count()) }}
                        </p>

                    </div>

                    <div class="h-1.5 bg-blue-600"></div>

                </div>

                <div class="overflow-hidden rounded-xl bg-white shadow-sm transition hover:shadow-md">

                    <div class="p-6">

                        <div class="flex items-start justify-between">
                            <p class="text-sm text-gray-500">Vencido</p>

                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-100 text-lg">
                                🔴
                            </div>
                        </div>

                        <p class="mt-3 text-2xl font-bold text-gray-800">
                            ${{ number_format($totalVencido, 0, ',', '.') }}
                        </p>

                        <p class="mt-1 text-sm text-gray-500">
                            {{ $cobrosVencidos->count() }} {{ Str::plural('cuota', $cobrosVencidos->count()) }}
                        </p>

                    </div>

                    <div class="h-1.5 bg-red-600"></div>

                </div>

                <div class="overflow-hidden rounded-xl bg-white shadow-sm transition hover:shadow-md">

                    <div class="p-6">

                        <div class="flex items-start justify-between">
                            <p class="text-sm text-gray-500">Cobrado hoy</p>

                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-100 text-lg">
                                💵
                            </div>
                        </div>

                        <p class="mt-3 text-2xl font-bold text-gray-800">
                            ${{ number_format($cobradoHoy, 0, ',', '.') }}
                        </p>

                        <p class="mt-1 text-sm text-gray-500">
                            Pagos registrados hoy
                        </p>

                    </div>

                    <div class="h-1.5 bg-green-600"></div>

                </div>

                <div class="overflow-hidden rounded-xl bg-white shadow-sm transition hover:shadow-md">

                    <div class="p-6">

                        <div class="flex items-start justify-between">
                            <p class="text-sm text-gray-500">Clientes por cobrar</p>

                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-lg">
                                👤
                            </div>
                        </div>

                        <p class="mt-3 text-2xl font-bold text-gray-800">
                            {{ $clientesConDeuda->count() }}
                        </p>

                        <p class="mt-1 text-sm text-gray-500">
                            Con cobros hoy o vencidos
                        </p>

                    </div>

                    <div class="h-1.5 bg-gray-400"></div>

                </div>

            </div>


            {{-- CLIENTES QUE DEBEN PAGAR --}}
            <div class="mt-8 overflow-hidden rounded-xl bg-white shadow-sm">

                <div class="flex items-center justify-between border-b border-gray-200 p-6">

                    <div>
                        <h2 class="text-lg font-bold text-gray-800">
                            Clientes que deben pagar
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Con cuotas por cobrar hoy o vencidas
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

                            <div class="flex flex-col gap-4 p-5 transition hover:bg-gray-50 sm:flex-row sm:items-center sm:justify-between">

                                <div class="flex items-center gap-4">

                                    <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-full bg-blue-100 font-bold text-blue-700">
                                        {{ strtoupper(substr($item->cliente->nombre, 0, 1)) }}
                                    </div>

                                    <div>

                                        <div class="flex flex-wrap items-center gap-2">

                                            <p class="font-semibold text-gray-800">
                                                {{ $item->cliente->nombre }}
                                            </p>

                                            @if($item->tiene_vencidas)

                                                <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                                    Vencido
                                                </span>

                                            @else

                                                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                                    Vence hoy
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

                                    <p class="text-lg font-bold text-gray-800">
                                        ${{ number_format($item->total_adeudado, 0, ',', '.') }}
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


            {{-- DOS COLUMNAS: COBROS DE HOY / VENCIDOS --}}
            <div class="mt-8 grid gap-8 lg:grid-cols-2">

                {{-- COBROS DE HOY --}}
                <div class="overflow-hidden rounded-xl bg-white shadow-sm">

                    <div class="flex items-center justify-between border-b border-gray-200 p-6">

                        <h2 class="flex items-center gap-2 text-lg font-bold text-gray-800">
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

                                <div class="flex items-center justify-between gap-3 p-5 transition hover:bg-gray-50">

                                    <div class="flex items-center gap-3">

                                        <span class="h-2.5 w-2.5 flex-shrink-0 rounded-full bg-blue-500"></span>

                                        <div>
                                            <p class="font-semibold text-gray-800">
                                                {{ $cuota->prestamo->cliente->nombre }}
                                            </p>

                                            <p class="text-sm text-gray-500">
                                                Préstamo #{{ $cuota->prestamo_id }} &middot; Cuota #{{ $cuota->numero_cuota }}
                                            </p>
                                        </div>

                                    </div>

                                    <div class="flex flex-shrink-0 items-center gap-3">

                                        <p class="font-bold text-blue-600">
                                            ${{ number_format($cuota->saldo_pendiente, 0, ',', '.') }}
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

                        <h2 class="flex items-center gap-2 text-lg font-bold text-gray-800">
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

                                <div class="flex items-center justify-between gap-3 p-5 transition hover:bg-gray-50">

                                    <div class="flex items-center gap-3">

                                        <span class="h-2.5 w-2.5 flex-shrink-0 rounded-full bg-red-500"></span>

                                        <div>
                                            <p class="font-semibold text-gray-800">
                                                {{ $cuota->prestamo->cliente->nombre }}
                                            </p>

                                            <p class="text-sm text-red-600">
                                                Préstamo #{{ $cuota->prestamo_id }} &middot; Cuota #{{ $cuota->numero_cuota }}
                                                &middot; {{ $diasRetraso }} {{ Str::plural('día', $diasRetraso) }} de retraso
                                            </p>
                                        </div>

                                    </div>

                                    <div class="flex flex-shrink-0 items-center gap-3">

                                        <p class="font-bold text-red-600">
                                            ${{ number_format($cuota->saldo_pendiente, 0, ',', '.') }}
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

        </main>

    </div>

</div>

</body>

</html>