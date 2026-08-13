<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-gray-100">

<div class="max-w-7xl mx-auto py-10">

    <a href="{{ route('dashboard.index') }}"
       class="inline-flex items-center gap-2 text-gray-500 hover:text-blue-600 mb-6">

        ← Volver al dashboard

    </a>

    <div class="flex justify-between items-center mb-6">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Clientes
            </h1>

            <p class="text-gray-500">
                Administración de clientes
            </p>
        </div>

        <a href="{{ route('clientes.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">

            + Nuevo Cliente

        </a>

    </div>

    @if(session('success'))

        <div class="bg-green-100 border border-green-300 text-green-700 p-4 rounded-lg mb-5">

            {{ session('success') }}

        </div>

    @endif

    <div class="bg-white rounded-xl shadow">

        <div class="p-6 border-b">

            <form method="GET">

                <input
                    type="text"
                    name="buscar"
                    value="{{ request('buscar') }}"
                    placeholder="Buscar por nombre, documento o teléfono..."
                    class="w-full border rounded-lg px-4 py-3">

            </form>

        </div>

        <table class="w-full">

            <thead class="bg-gray-100">

                <tr>

                    <th class="p-4 text-left">Nombre</th>
                    <th class="p-4 text-left">Documento</th>
                    <th class="p-4 text-left">Teléfono</th>
                    <th class="p-4 text-left">Estado</th>
                    <th class="p-4 text-center">Acciones</th>

                </tr>

            </thead>

            <tbody>

            @forelse($clientes as $cliente)

                <tr class="border-b hover:bg-gray-50">

                    <td class="p-4">

                        {{ $cliente->nombre }}

                    </td>

                    <td class="p-4">

                        {{ $cliente->documento }}

                    </td>

                    <td class="p-4">

                        {{ $cliente->telefono }}

                    </td>

                    <td class="p-4">

                        @if($cliente->estado=="activo")

                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">

                                Activo

                            </span>

                        @else

                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">

                                Inactivo

                            </span>

                        @endif

                    </td>

                    <td class="p-4">

                        <div class="flex justify-center gap-2">

                            <a
                                href="{{ route('clientes.show',$cliente) }}"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded">

                                Ver

                            </a>

                            <a
                                href="{{ route('clientes.edit',$cliente) }}"
                                class="bg-yellow-500 hover:bg-yellow-600 text-black px-3 py-2 rounded">

                                Editar

                            </a>

                            <form
                                action="{{ route('clientes.destroy',$cliente) }}"
                                method="POST"
                                onsubmit="return confirm('¿Desea desactivar este cliente?')">

                                @csrf
                                @method('DELETE')

                                <button
                                    class="bg-red-600 hover:bg-red-700 text-black px-3 py-2 rounded">

                                    Desactivar

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="5" class="text-center py-12 text-gray-500">

                        No hay clientes registrados.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

        <div class="p-6">

            {{ $clientes->links() }}

        </div>

    </div>

</div>

</body>
</html>