<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registrar pago</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-gray-100 min-h-screen">

<div class="max-w-5xl mx-auto px-4 py-10">

    {{-- MENSAJES DE ERROR --}}
    @if($errors->any())

        <div class="mb-6 rounded-xl border border-red-300 bg-red-50 p-5 text-red-700">

            <h3 class="font-bold mb-2">
                Corrige los siguientes errores:
            </h3>

            <ul class="list-disc ml-5 space-y-1">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- ENCABEZADO --}}
    <div class="mb-8">

        <a
            href="{{ route('prestamos.show', $cuota->prestamo_id) }}"
            class="inline-block mb-4 text-blue-600 hover:text-blue-800 font-medium"
        >
            ← Volver al préstamo
        </a>

        <h1 class="text-3xl font-bold text-gray-800">
            Registrar pago
        </h1>

        <p class="mt-1 text-gray-500">
            Registra un abono a la cuota #{{ $cuota->numero_cuota }}
        </p>

    </div>


    {{-- INFORMACIÓN DE LA CUOTA --}}
    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">

        <div class="bg-blue-600 text-white px-6 py-5">

            <h2 class="text-xl font-bold">
                Cuota #{{ $cuota->numero_cuota }}
            </h2>

            <p class="text-blue-100 mt-1">
                Cliente:
                {{ $cuota->prestamo->cliente->nombre }}
            </p>

        </div>


        <div class="grid md:grid-cols-3 gap-6 p-6">

            {{-- CAPITAL --}}
            <div class="rounded-lg bg-gray-50 p-5">

                <p class="text-sm font-medium text-gray-500">
                    Saldo de capital
                </p>

                <p class="mt-2 text-2xl font-bold text-gray-800">
                    ${{ number_format($cuota->saldo_capital, 2) }}
                </p>

            </div>


            {{-- INTERÉS --}}
            <div class="rounded-lg bg-gray-50 p-5">

                <p class="text-sm font-medium text-gray-500">
                    Saldo de interés
                </p>

                <p class="mt-2 text-2xl font-bold text-gray-800">
                    ${{ number_format($cuota->saldo_interes, 2) }}
                </p>

            </div>


            {{-- TOTAL --}}
            <div class="rounded-lg bg-blue-50 p-5">

                <p class="text-sm font-medium text-blue-600">
                    Saldo total
                </p>

                <p class="mt-2 text-2xl font-bold text-blue-700">
                    ${{ number_format($cuota->saldo_pendiente, 2) }}
                </p>

            </div>

        </div>

    </div>


    {{-- FORMULARIO --}}
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">

        <div class="border-b border-gray-200 px-6 py-5">

            <h2 class="text-2xl font-bold text-gray-800">
                Datos del pago
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Puedes abonar a capital, a interés o a ambos.
            </p>

        </div>


        <form
            action="{{ route('cobros.store', $cuota) }}"
            method="POST"
            class="p-6"
        >

            @csrf


            <div class="grid md:grid-cols-2 gap-6">

                {{-- CAPITAL --}}
                <div>

                    <label
                        for="monto_capital"
                        class="block mb-2 font-semibold text-gray-700"
                    >
                        Abono a capital
                    </label>

                    <div class="relative">

                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">
                            $
                        </span>

                        <input
                            type="number"
                            name="monto_capital"
                            id="monto_capital"
                            value="{{ old('monto_capital', '') }}"
                            min="0"
                            max="{{ $cuota->saldo_capital }}"
                            step="0.01"
                            placeholder="0.00"
                            class="w-full rounded-lg border border-gray-300 py-3 pl-9 pr-4 text-gray-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                        >

                    </div>

                    <p class="mt-2 text-sm text-gray-500">
                        Máximo:
                        ${{ number_format($cuota->saldo_capital, 2) }}
                    </p>

                </div>


                {{-- INTERÉS --}}
                <div>

                    <label
                        for="monto_interes"
                        class="block mb-2 font-semibold text-gray-700"
                    >
                        Abono a interés
                    </label>

                    <div class="relative">

                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">
                            $
                        </span>

                        <input
                            type="number"
                            name="monto_interes"
                            id="monto_interes"
                            value="{{ old('monto_interes', '') }}"
                            min="0"
                            max="{{ $cuota->saldo_interes }}"
                            step="0.01"
                            placeholder="0.00"
                            class="w-full rounded-lg border border-gray-300 py-3 pl-9 pr-4 text-gray-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                        >

                    </div>

                    <p class="mt-2 text-sm text-gray-500">
                        Máximo:
                        ${{ number_format($cuota->saldo_interes, 2) }}
                    </p>

                </div>


                {{-- TOTAL --}}
                <div>

                    <label
                        class="block mb-2 font-semibold text-gray-700"
                    >
                        Total del abono
                    </label>

                    <div
                        id="total-abono"
                        class="rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-2xl font-bold text-green-700"
                    >
                        $0.00
                    </div>

                </div>


                {{-- FECHA --}}
                <div>

                    <label
                        for="fecha_pago"
                        class="block mb-2 font-semibold text-gray-700"
                    >
                        Fecha del pago
                    </label>

                    <input
                        type="date"
                        name="fecha_pago"
                        id="fecha_pago"
                        value="{{ old('fecha_pago', now()->format('Y-m-d')) }}"
                        required
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                    >

                </div>


                {{-- MÉTODO --}}
                <div>

                    <label
                        for="metodo_pago"
                        class="block mb-2 font-semibold text-gray-700"
                    >
                        Método de pago
                    </label>

                    <select
                        name="metodo_pago"
                        id="metodo_pago"
                        required
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                    >

                        <option value="">
                            Selecciona un método
                        </option>

                        <option
                            value="efectivo"
                            {{ old('metodo_pago') === 'efectivo' ? 'selected' : '' }}
                        >
                            Efectivo
                        </option>

                        <option
                            value="transferencia"
                            {{ old('metodo_pago') === 'transferencia' ? 'selected' : '' }}
                        >
                            Transferencia
                        </option>

                        <option
                            value="otro"
                            {{ old('metodo_pago') === 'otro' ? 'selected' : '' }}
                        >
                            Otro
                        </option>

                    </select>

                </div>


                {{-- OBSERVACIONES --}}
                <div class="md:col-span-2">

                    <label
                        for="observaciones"
                        class="block mb-2 font-semibold text-gray-700"
                    >
                        Observaciones
                    </label>

                    <textarea
                        name="observaciones"
                        id="observaciones"
                        rows="4"
                        placeholder="Observaciones opcionales..."
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                    >{{ old('observaciones') }}</textarea>

                </div>

            </div>


            {{-- BOTONES --}}
            <div class="mt-8 flex flex-wrap gap-3">

                <a
                    href="{{ route('prestamos.show', $cuota->prestamo_id) }}"
                    class="rounded-lg bg-gray-600 px-6 py-3 font-semibold text-white hover:bg-gray-700"
                >
                    Cancelar
                </a>

                <button
                    type="submit"
                    class="rounded-lg bg-green-600 px-6 py-3 font-semibold text-white shadow hover:bg-green-700"
                >
                    Registrar pago
                </button>

            </div>

        </form>

    </div>

</div>


<script>

    const capitalInput = document.getElementById('monto_capital');

    const interesInput = document.getElementById('monto_interes');

    const totalAbono = document.getElementById('total-abono');


    function actualizarTotal()
    {
        const capital =
            parseFloat(capitalInput.value) || 0;

        const interes =
            parseFloat(interesInput.value) || 0;

        const total =
            capital + interes;

        totalAbono.textContent =
            '$' + total.toLocaleString('es-CO', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
    }


    capitalInput.addEventListener(
        'input',
        actualizarTotal
    );

    interesInput.addEventListener(
        'input',
        actualizarTotal
    );


    actualizarTotal();

</script>

</body>

</html>