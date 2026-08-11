<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar Cliente</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

</head>

<body class="bg-gray-100">

<div class="max-w-4xl mx-auto py-10">

    <div class="bg-white rounded-xl shadow-lg">

        <div class="bg-blue-600 text-white px-8 py-6 rounded-t-xl">

            <h1 class="text-3xl font-bold">
                Editar Cliente
            </h1>

            <p class="mt-2">
                Modifica la información del cliente
            </p>

        </div>

        <form action="{{ route('clientes.update', $cliente) }}" method="POST" class="p-8">

            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-6">

                <div>
                    <label class="block font-semibold mb-2">
                        Nombre Completo
                    </label>

                    <input
                        type="text"
                        name="nombre"
                        value="{{ old('nombre', $cliente->nombre) }}"
                        class="w-full border rounded-lg px-4 py-3 @error('nombre') border-red-500 @enderror">

                    @error('nombre')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-semibold mb-2">
                        Documento
                    </label>

                    <input
                        type="text"
                        name="documento"
                        value="{{ old('documento', $cliente->documento) }}"
                        class="w-full border rounded-lg px-4 py-3 @error('documento') border-red-500 @enderror">

                    @error('documento')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-semibold mb-2">
                        Teléfono
                    </label>

                    <input
                        type="text"
                        name="telefono"
                        value="{{ old('telefono', $cliente->telefono) }}"
                        class="w-full border rounded-lg px-4 py-3">
                </div>

                <div>
                    <label class="block font-semibold mb-2">
                        Correo
                    </label>

                    <input
                        type="email"
                        name="correo"
                        value="{{ old('correo', $cliente->correo) }}"
                        class="w-full border rounded-lg px-4 py-3">
                </div>

                <div class="col-span-2">
                    <label class="block font-semibold mb-2">
                        Dirección
                    </label>

                    <textarea
                        name="direccion"
                        rows="3"
                        class="w-full border rounded-lg px-4 py-3">{{ old('direccion', $cliente->direccion) }}</textarea>
                </div>

                <div>
                    <label class="block font-semibold mb-2">
                        Estado
                    </label>

                    <select
                        name="estado"
                        class="w-full border rounded-lg px-4 py-3">

                        <option value="activo"
                            {{ $cliente->estado == 'activo' ? 'selected' : '' }}>
                            Activo
                        </option>

                        <option value="inactivo"
                            {{ $cliente->estado == 'inactivo' ? 'selected' : '' }}>
                            Inactivo
                        </option>

                    </select>
                </div>

            </div>

            <div class="flex justify-end gap-4 mt-8">

                <a href="{{ route('clientes.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg">

                    Cancelar

                </a>

                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">

                    Guardar Cambios

                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>