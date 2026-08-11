<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Cliente</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

<div class="max-w-7xl mx-auto py-10">

    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 p-4 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-lg">

        <div class="bg-blue-600 text-white px-8 py-6 rounded-t-xl flex justify-between items-center">

            <div>

                <h1 class="text-3xl font-bold">

                    {{ $cliente->nombre }}

                </h1>

                <p class="mt-2">

                    Información del cliente

                </p>

            </div>

            <span class="bg-white text-blue-700 px-4 py-2 rounded-full font-semibold">

                {{ ucfirst($cliente->estado) }}

            </span>

        </div>

        <div class="grid md:grid-cols-2 gap-6 p-8">

            <div>
                <strong>Documento</strong>
                <p>{{ $cliente->documento }}</p>
            </div>

            <div>
                <strong>Teléfono</strong>
                <p>{{ $cliente->telefono }}</p>
            </div>

            <div>
                <strong>Correo</strong>
                <p>{{ $cliente->correo ?? 'No registrado' }}</p>
            </div>

            <div>
                <strong>Dirección</strong>
                <p>{{ $cliente->direccion ?? 'No registrada' }}</p>
            </div>

        </div>

    </div>

    <div class="bg-white rounded-xl shadow-lg mt-8">

        <div class="flex justify-between items-center p-6 border-b">

           <div class="flex justify-between items-center p-6 border-b">

    <h2 class="text-2xl font-bold">
        Préstamos
    </h2>

    <a href="{{ route('prestamos.create', $cliente) }}"
       class="bg-green-600 hover:bg-green-700 text-black px-5 py-3 rounded-lg">

        + Nuevo préstamo

    </a>

</div>

            <a href="{{ route('prestamos.create', $cliente) }}"
               class="bg-green-600 hover:bg-green-700 text-black px-5 py-3 rounded-lg">

                + Nuevo préstamo

            </a>

        </div>

        <table class="w-full">

            <thead class="bg-gray-100">

                <tr>

                    <th class="p-4 text-left">Monto</th>
                    <th class="p-4 text-left">Interés</th>
                    <th class="p-4 text-left">Total</th>
                    <th class="p-4 text-left">Cuotas</th>
                    <th class="p-4 text-left">Estado</th>
                    <th class="p-4 text-center">Acciones</th>

                </tr>

            </thead>

            <tbody>

            @forelse($cliente->prestamos as $prestamo)

                <tr class="border-b hover:bg-gray-50">

                    <td class="p-4">
                        ${{ number_format($prestamo->monto_prestado,2) }}
                    </td>

                    <td class="p-4">
                        {{ $prestamo->interes }} %
                    </td>

                    <td class="p-4">
                        ${{ number_format($prestamo->total_pagar,2) }}
                    </td>

                    <td class="p-4">
                        {{ $prestamo->numero_cuotas }}
                    </td>

                    <td class="p-4">

                        @if($prestamo->estado=="activo")

                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">

                                Activo

                            </span>

                        @else

                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">

                                Finalizado

                            </span>

                        @endif

                    </td>

                    <td class="p-4 text-center">

                        <a href="{{ route('prestamos.show',$prestamo) }}"
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">

                            Ver préstamo

                        </a>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="6" class="text-center py-10 text-gray-500">

                        Este cliente aún no tiene préstamos registrados.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-8">

        <a href="{{ route('clientes.index') }}"
           class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg">

            ← Volver

        </a>

    </div>

</div>

</body>
</html>