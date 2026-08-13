<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Contabilidad</title>

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
                class="flex items-center gap-3 rounded-lg px-4 py-3 text-slate-300 transition hover:bg-slate-800 hover:text-white"
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
                class="flex items-center gap-3 rounded-lg bg-blue-600 px-4 py-3 font-medium text-white transition"
            >
                <span>🧮</span>
                <span>Contabilidad</span>
            </a>

            <a
                href="#"
                class="flex items-center gap-3 rounded-lg px-4 py-3 text-slate-300 transition hover:bg-slate-800 hover:text-white"
            >
                <span>📊</span>
                <span>Reportes</span>
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
                Contabilidad
            </h2>

            <a
                href="{{ route('gastos.create') }}"
                class="rounded-lg bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700"
            >
                + Registrar gasto
            </a>

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
                        🧮
                    </div>

                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">
                            Ingresos y egresos
                        </h1>

                        <p class="text-sm text-gray-500">
                            Resumen financiero del negocio
                        </p>
                    </div>

                </div>

                <div class="rounded-lg bg-gray-100 px-4 py-2 text-sm text-gray-600">
                    Semana:
                    <span class="font-semibold text-gray-800">
                        {{ $inicioSemana->format('d/m') }} — {{ $finSemana->format('d/m') }}
                    </span>
                    &middot;
                    Mes:
                    <span class="font-semibold text-gray-800">
                        {{ ucfirst($hoy->locale('es')->isoFormat('MMMM YYYY')) }}
                    </span>
                </div>

            </div>


            {{-- GANANCIA LIBRE MENSUAL --}}
            <div class="mb-8 overflow-hidden rounded-xl bg-white shadow-sm">

                <div class="flex flex-col gap-4 p-6 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <p class="text-sm text-gray-500">Ganancia libre mensual</p>
                        <p class="mt-1 text-sm text-gray-400">
                            Cobrado del mes − gastado del mes
                        </p>
                    </div>

                    <p class="text-4xl font-bold {{ $gananciaLibreMes >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        ${{ number_format($gananciaLibreMes, 2, ',', '.') }}
                    </p>

                </div>

                <div class="h-1.5 {{ $gananciaLibreMes >= 0 ? 'bg-green-600' : 'bg-red-600' }}"></div>

            </div>


            {{-- INGRESOS --}}
            <h2 class="mb-4 flex items-center gap-2 text-lg font-bold text-gray-800">
                <span class="h-2.5 w-2.5 rounded-full bg-green-600"></span>
                Ingresos
            </h2>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">

                <div class="overflow-hidden rounded-xl bg-white shadow-sm transition hover:shadow-md">

                    <div class="p-6">

                        <div class="flex items-start justify-between">
                            <p class="text-sm text-gray-500">Cobrado esta semana</p>

                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-100 text-lg">
                                💵
                            </div>
                        </div>

                        <p class="mt-3 text-2xl font-bold text-gray-800">
                            ${{ number_format($cobradoSemana, 2, ',', '.') }}
                        </p>

                    </div>

                    <div class="h-1.5 bg-green-600"></div>

                </div>

                <div class="overflow-hidden rounded-xl bg-white shadow-sm transition hover:shadow-md">

                    <div class="p-6">

                        <div class="flex items-start justify-between">
                            <p class="text-sm text-gray-500">Cobrado este mes</p>

                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-100 text-lg">
                                💰
                            </div>
                        </div>

                        <p class="mt-3 text-2xl font-bold text-gray-800">
                            ${{ number_format($cobradoMes, 2, ',', '.') }}
                        </p>

                    </div>

                    <div class="h-1.5 bg-green-600"></div>

                </div>

                <div class="overflow-hidden rounded-xl bg-white shadow-sm transition hover:shadow-md">

                    <div class="p-6">

                        <div class="flex items-start justify-between">
                            <p class="text-sm text-gray-500">Prestado esta semana</p>

                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 text-lg">
                                📤
                            </div>
                        </div>

                        <p class="mt-3 text-2xl font-bold text-gray-800">
                            ${{ number_format($prestadoSemana, 2, ',', '.') }}
                        </p>

                    </div>

                    <div class="h-1.5 bg-blue-600"></div>

                </div>

                <div class="overflow-hidden rounded-xl bg-white shadow-sm transition hover:shadow-md">

                    <div class="p-6">

                        <div class="flex items-start justify-between">
                            <p class="text-sm text-gray-500">Prestado este mes</p>

                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 text-lg">
                                📤
                            </div>
                        </div>

                        <p class="mt-3 text-2xl font-bold text-gray-800">
                            ${{ number_format($prestadoMes, 2, ',', '.') }}
                        </p>

                    </div>

                    <div class="h-1.5 bg-blue-600"></div>

                </div>

            </div>


            {{-- EGRESOS --}}
            <h2 class="mb-4 mt-10 flex items-center gap-2 text-lg font-bold text-gray-800">
                <span class="h-2.5 w-2.5 rounded-full bg-red-600"></span>
                Egresos del mes
            </h2>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">

                <div class="overflow-hidden rounded-xl bg-white shadow-sm transition hover:shadow-md">

                    <div class="p-6">

                        <div class="flex items-start justify-between">
                            <p class="text-sm text-gray-500">Gastado en total</p>

                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-100 text-lg">
                                🧾
                            </div>
                        </div>

                        <p class="mt-3 text-2xl font-bold text-gray-800">
                            ${{ number_format($gastadoMes, 2, ',', '.') }}
                        </p>

                    </div>

                    <div class="h-1.5 bg-red-600"></div>

                </div>

                <div class="overflow-hidden rounded-xl bg-white shadow-sm transition hover:shadow-md">

                    <div class="p-6">

                        <div class="flex items-start justify-between">
                            <p class="text-sm text-gray-500">Pago al trabajador</p>

                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-orange-100 text-lg">
                                👷
                            </div>
                        </div>

                        <p class="mt-3 text-2xl font-bold text-gray-800">
                            ${{ number_format($trabajadorMes, 2, ',', '.') }}
                        </p>

                    </div>

                    <div class="h-1.5 bg-orange-500"></div>

                </div>

                <div class="overflow-hidden rounded-xl bg-white shadow-sm transition hover:shadow-md">

                    <div class="p-6">

                        <div class="flex items-start justify-between">
                            <p class="text-sm text-gray-500">Gasolina</p>

                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-yellow-100 text-lg">
                                ⛽
                            </div>
                        </div>

                        <p class="mt-3 text-2xl font-bold text-gray-800">
                            ${{ number_format($gasolinaMes, 2, ',', '.') }}
                        </p>

                    </div>

                    <div class="h-1.5 bg-yellow-500"></div>

                </div>

                <div class="overflow-hidden rounded-xl bg-white shadow-sm transition hover:shadow-md">

                    <div class="p-6">

                        <div class="flex items-start justify-between">
                            <p class="text-sm text-gray-500">Otros gastos</p>

                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-lg">
                                📦
                            </div>
                        </div>

                        <p class="mt-3 text-2xl font-bold text-gray-800">
                            ${{ number_format($otrosGastosMes, 2, ',', '.') }}
                        </p>

                    </div>

                    <div class="h-1.5 bg-gray-400"></div>

                </div>

            </div>


            {{-- ÚLTIMOS GASTOS --}}
            <div class="mt-8 overflow-hidden rounded-xl bg-white shadow-sm">

                <div class="flex items-center justify-between border-b border-gray-200 p-6">

                    <h2 class="text-lg font-bold text-gray-800">
                        Últimos gastos registrados
                    </h2>

                    <a
                        href="{{ route('gastos.index') }}"
                        class="rounded-full bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700 transition hover:bg-blue-100"
                    >
                        Ver todos
                    </a>

                </div>

                @if($ultimosGastos->count() > 0)

                    <div class="divide-y divide-gray-100">

                        @foreach($ultimosGastos as $gasto)

                            @php
                                $colores = [
                                    'trabajador' => 'bg-orange-100 text-orange-700',
                                    'gasolina' => 'bg-yellow-100 text-yellow-700',
                                    'otro' => 'bg-gray-100 text-gray-700',
                                ];
                            @endphp

                            <div class="flex items-center justify-between gap-3 p-5">

                                <div>

                                    <div class="flex items-center gap-2">

                                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $colores[$gasto->categoria] ?? 'bg-gray-100 text-gray-700' }}">
                                            {{ \App\Models\Gasto::CATEGORIAS[$gasto->categoria] ?? $gasto->categoria }}
                                        </span>

                                        <p class="text-sm text-gray-500">
                                            {{ $gasto->fecha->format('d/m/Y') }}
                                        </p>

                                    </div>

                                    @if($gasto->descripcion)
                                        <p class="mt-1 text-sm text-gray-600">
                                            {{ $gasto->descripcion }}
                                        </p>
                                    @endif

                                </div>

                                <p class="font-bold text-red-600">
                                    ${{ number_format($gasto->monto, 2, ',', '.') }}
                                </p>

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="px-6 py-12 text-center">
                        <div class="text-4xl">🧾</div>
                        <p class="mt-3 text-gray-500">
                            Todavía no has registrado ningún gasto.
                        </p>
                    </div>

                @endif

            </div>

        </main>

    </div>

</div>

</body>

</html>