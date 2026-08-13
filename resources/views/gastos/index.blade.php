<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gastos</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

<div class="max-w-7xl mx-auto py-10 px-4">

    <a href="{{ route('contabilidad.index') }}"
       class="inline-flex items-center gap-2 text-gray-500 hover:text-blue-600 mb-6">

        ← Volver a contabilidad

    </a>

    <div class="flex justify-between items-center mb-6">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Gastos
            </h1>

            <p class="text-gray-500">
                Registro de egresos: trabajador, gasolina y otros gastos
            </p>
        </div>

        <a href="{{ route('gastos.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">

            + Nuevo Gasto

        </a>

    </div>

    @if(session('success'))

        <div class="bg-green-100 border border-green-300 text-green-700 p-4 rounded-lg mb-5">
            {{ session('success') }}
        </div>

    @endif

    {{-- FILTROS --}}
    <div class="bg-white rounded-xl shadow mb-6">

        <div class="p-6">

            <form method="GET" class="flex flex-col gap-4 sm:flex-row sm:items-end">

                <div class="flex-1">
                    <label class="block mb-2 text-sm font-semibold text-gray-600">Categoría</label>

                    <select name="categoria" class="w-full border rounded-lg px-4 py-3">
                        <option value="">Todas</option>

                        @foreach(\App\Models\Gasto::CATEGORIAS as $valor => $etiqueta)
                            <option value="{{ $valor }}" @selected($categoria === $valor)>
                                {{ $etiqueta }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex-1">
                    <label class="block mb-2 text-sm font-semibold text-gray-600">Mes</label>

                    <input
                        type="month"
                        name="mes"
                        value="{{ $mes ?? '' }}"
                        class="w-full border rounded-lg px-4 py-3">
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Filtrar
                    </button>

                    <a href="{{ route('gastos.index') }}"
                        class="px-6 py-3 bg-gray-200 rounded-lg hover:bg-gray-300">
                        Limpiar
                    </a>
                </div>

            </form>

        </div>

        @if($categoria || $mes)

            <div class="border-t border-gray-200 px-6 py-4 bg-gray-50 flex items-center justify-between">
                <p class="text-sm text-gray-600">Total con estos filtros (esta página)</p>
                <p class="text-xl font-bold text-red-600">
                    ${{ number_format($totalFiltrado, 2, ',', '.') }}
                </p>
            </div>

        @endif

    </div>

    {{-- TABLA --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">

        @if($gastos->count() > 0)

            <table class="w-full">

                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Fecha</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Categoría</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Descripción</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Monto</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-600">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">

                    @foreach($gastos as $gasto)

                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-4 text-gray-700">
                                {{ $gasto->fecha->format('d/m/Y') }}
                            </td>

                            <td class="px-6 py-4">
                                @php
                                    $colores = [
                                        'trabajador' => 'bg-blue-100 text-blue-700',
                                        'gasolina' => 'bg-yellow-100 text-yellow-700',
                                        'otro' => 'bg-gray-100 text-gray-700',
                                    ];
                                @endphp

                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $colores[$gasto->categoria] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ \App\Models\Gasto::CATEGORIAS[$gasto->categoria] ?? $gasto->categoria }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ $gasto->descripcion ?: '—' }}
                            </td>

                            <td class="px-6 py-4 font-bold text-red-600">
                                ${{ number_format($gasto->monto, 2, ',', '.') }}
                            </td>

                            <td class="px-6 py-4 text-right">

                                <div class="flex justify-end gap-2">

                                    <a href="{{ route('gastos.edit', $gasto) }}"
                                        class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 text-sm font-semibold">
                                        Editar
                                    </a>

                                    <form action="{{ route('gastos.destroy', $gasto) }}" method="POST"
                                          onsubmit="return confirm('¿Eliminar este gasto?');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-semibold">
                                            Eliminar
                                        </button>
                                    </form>

                                </div>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

            <div class="p-6">
                {{ $gastos->links() }}
            </div>

        @else

            <div class="px-6 py-12 text-center text-gray-500">
                No hay gastos registrados con estos filtros.
            </div>

        @endif

    </div>

</div>

</body>

</html>