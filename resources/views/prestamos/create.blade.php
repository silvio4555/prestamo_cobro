<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Nuevo préstamo</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="bg-gray-100">

<div class="mx-auto max-w-5xl px-4 py-10">


    {{-- ENCABEZADO --}}

    <div class="mb-8">

        <h1 class="text-3xl font-bold text-gray-800">
            Nuevo préstamo
        </h1>

        <p class="mt-2 text-gray-500">
            Registrar préstamo para
            <span class="font-semibold text-gray-700">
                {{ $cliente->nombre }}
            </span>
        </p>

    </div>



    {{-- MENSAJES DE ERROR --}}

    @if ($errors->any())

        <div class="mb-6 rounded-lg border border-red-300 bg-red-100 px-5 py-4 text-red-700">

            <p class="font-semibold">
                Hay errores en el formulario:
            </p>

            <ul class="mt-2 list-inside list-disc">

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif



    {{-- FORMULARIO --}}

    <form
        action="{{ route('prestamos.store', $cliente) }}"
        method="POST"
        id="formPrestamo"
        class="overflow-hidden rounded-xl bg-white shadow-lg"
    >

        @csrf



        {{-- INFORMACIÓN DEL CLIENTE --}}

        <div class="border-b border-gray-200 bg-blue-600 px-8 py-6 text-white">

            <h2 class="text-2xl font-bold">
                Información del cliente
            </h2>

            <p class="mt-1 text-blue-100">
                {{ $cliente->nombre }}
            </p>

        </div>



        {{-- DATOS DEL PRÉSTAMO --}}

        <div class="grid gap-6 p-8 md:grid-cols-2">


            {{-- MONTO --}}

            <div>

                <label
                    for="monto_prestado"
                    class="mb-2 block font-semibold text-gray-700"
                >
                    Monto prestado
                </label>

                <input
                    type="number"
                    name="monto_prestado"
                    id="monto_prestado"
                    step="0.01"
                    min="0.01"
                    value="{{ old('monto_prestado') }}"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                    placeholder="Ej: 200000"
                >

            </div>



            {{-- INTERÉS --}}

            <div>

                <label
                    for="tasa_interes"
                    class="mb-2 block font-semibold text-gray-700"
                >
                    Interés por período (%)
                </label>

                <div class="relative">

                    <input
                        type="number"
                        name="tasa_interes"
                        id="tasa_interes"
                        step="0.01"
                        min="0"
                        value="{{ old('tasa_interes') }}"
                        required
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 pr-12 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                        placeholder="Ej: 20"
                    >

                    <span class="absolute right-4 top-1/2 -translate-y-1/2 font-semibold text-gray-500">
                        %
                    </span>

                </div>

                <p class="mt-1 text-sm text-gray-500">
                    El porcentaje se cobra en cada período.
                </p>

            </div>



            {{-- FRECUENCIA --}}

            <div>

                <label
                    for="frecuencia"
                    class="mb-2 block font-semibold text-gray-700"
                >
                    Frecuencia de pago
                </label>

                <select
                    name="frecuencia"
                    id="frecuencia"
                    required
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                >

                    <option value="">
                        Seleccionar frecuencia
                    </option>

                    <option
                        value="semanal"
                        {{ old('frecuencia') == 'semanal' ? 'selected' : '' }}
                    >
                        Semanal
                    </option>

                    <option
                        value="quincenal"
                        {{ old('frecuencia') == 'quincenal' ? 'selected' : '' }}
                    >
                        Quincenal
                    </option>

                    <option
                        value="mensual"
                        {{ old('frecuencia') == 'mensual' ? 'selected' : '' }}
                    >
                        Mensual
                    </option>

                </select>

            </div>



            {{-- NÚMERO DE CUOTAS --}}

            <div>

                <label
                    for="numero_cuotas"
                    class="mb-2 block font-semibold text-gray-700"
                >
                    Número de cuotas
                </label>

                <input
                    type="number"
                    name="numero_cuotas"
                    id="numero_cuotas"
                    min="1"
                    step="1"
                    value="{{ old('numero_cuotas') }}"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                    placeholder="Ej: 2"
                >

            </div>



            {{-- FECHA DEL PRÉSTAMO --}}

            <div>

                <label
                    for="fecha_prestamo"
                    class="mb-2 block font-semibold text-gray-700"
                >
                    Fecha del préstamo
                </label>

                <input
                    type="date"
                    name="fecha_prestamo"
                    id="fecha_prestamo"
                    value="{{ old('fecha_prestamo', date('Y-m-d')) }}"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                >

            </div>



            {{-- FECHA PRIMER PAGO --}}

            <div>

                <label
                    for="fecha_primer_pago"
                    class="mb-2 block font-semibold text-gray-700"
                >
                    Fecha del primer pago
                </label>

                <input
                    type="date"
                    name="fecha_primer_pago"
                    id="fecha_primer_pago"
                    value="{{ old('fecha_primer_pago') }}"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                >

            </div>



            {{-- OBSERVACIONES --}}

            <div class="md:col-span-2">

                <label
                    for="observaciones"
                    class="mb-2 block font-semibold text-gray-700"
                >
                    Observaciones
                </label>

                <textarea
                    name="observaciones"
                    id="observaciones"
                    rows="4"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                    placeholder="Observaciones del préstamo..."
                >{{ old('observaciones') }}</textarea>

            </div>

        </div>



        {{-- RESUMEN DEL PRÉSTAMO --}}

        <div class="border-t border-gray-200 bg-gray-50 p-8">

            <h2 class="mb-6 text-xl font-bold text-gray-800">
                Resumen del préstamo
            </h2>


            <div class="grid gap-6 md:grid-cols-2">


                {{-- MONTO --}}

                <div>

                    <p class="text-sm text-gray-500">
                        Monto
                    </p>

                    <p
                        id="montoResultado"
                        class="mt-1 text-2xl font-bold text-gray-800"
                    >
                        $0,00
                    </p>

                </div>



                {{-- INTERÉS TOTAL --}}

                <div>

                    <p class="text-sm text-gray-500">
                        Interés total
                    </p>

                    <p
                        id="interesTotal"
                        class="mt-1 text-2xl font-bold text-gray-800"
                    >
                        $0,00
                    </p>

                </div>



                {{-- TOTAL A PAGAR --}}

                <div>

                    <p class="text-sm text-gray-500">
                        Total a pagar
                    </p>

                    <p
                        id="totalPagar"
                        class="mt-1 text-2xl font-bold text-green-600"
                    >
                        $0,00
                    </p>

                </div>



                {{-- VALOR CUOTA --}}

                <div>

                    <p class="text-sm text-gray-500">
                        Valor por cuota
                    </p>

                    <p
                        id="valorCuota"
                        class="mt-1 text-2xl font-bold text-gray-800"
                    >
                        $0,00
                    </p>

                </div>

            </div>


            

        </div>



        {{-- BOTONES --}}

        <div class="flex flex-col gap-3 border-t border-gray-200 p-8 md:flex-row">


            <a
                href="{{ route('clientes.show', $cliente) }}"
                class="w-full rounded-lg bg-gray-500 px-6 py-4 text-center font-semibold text-white transition hover:bg-gray-600"
            >
                Cancelar
            </a>


            <button
                type="submit"
                class="w-full rounded-lg bg-green-600 px-6 py-4 font-semibold text-white transition hover:bg-green-700"
            >
                Guardar préstamo
            </button>


        </div>

    </form>

</div>



{{-- CÁLCULO AUTOMÁTICO --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const montoInput = document.getElementById('monto_prestado');

    const interesInput = document.getElementById('tasa_interes');

    const cuotasInput = document.getElementById('numero_cuotas');

    const frecuenciaInput = document.getElementById('frecuencia');


    const montoResultado = document.getElementById('montoResultado');

    const interesTotalResultado = document.getElementById('interesTotal');

    const totalPagarResultado = document.getElementById('totalPagar');

    const valorCuotaResultado = document.getElementById('valorCuota');

    const explicacion = document.getElementById('explicacionCalculo');

    const textoCalculo = document.getElementById('textoCalculo');


    function moneda(valor) {

        return new Intl.NumberFormat('es-CO', {

            style: 'currency',

            currency: 'COP',

            minimumFractionDigits: 2,

            maximumFractionDigits: 2

        }).format(valor);

    }


    function calcular() {

        const monto =
            parseFloat(montoInput.value) || 0;


        const interes =
            parseFloat(interesInput.value) || 0;


        const cuotas =
            parseInt(cuotasInput.value) || 0;


        const frecuencia =
            frecuenciaInput.value;



        const interesPorPeriodo =
            monto * (interes / 100);


        const interesTotal =
            interesPorPeriodo * cuotas;


        const totalPagar =
            monto + interesTotal;


        const valorCuota =
            cuotas > 0
                ? totalPagar / cuotas
                : 0;


        // Mostrar resultados

        montoResultado.textContent =
            moneda(monto);


        interesTotalResultado.textContent =
            moneda(interesTotal);


        totalPagarResultado.textContent =
            moneda(totalPagar);


        valorCuotaResultado.textContent =
            moneda(valorCuota);


        // Mostrar explicación

        if (
            monto > 0 &&
            interes > 0 &&
            cuotas > 0
        ) {

            explicacion.classList.remove('hidden');


            let nombreFrecuencia = frecuencia;

            if (frecuencia === 'semanal') {
                nombreFrecuencia = 'semanal';
            }

            if (frecuencia === 'quincenal') {
                nombreFrecuencia = 'quincenal';
            }

            if (frecuencia === 'mensual') {
                nombreFrecuencia = 'mensual';
            }


            textoCalculo.textContent =
                `${moneda(monto)} × ${interes}% = ${moneda(interesPorPeriodo)} de interés por período. ` +
                `${moneda(interesPorPeriodo)} × ${cuotas} ${nombreFrecuencia}(s) = ${moneda(interesTotal)} de interés total. ` +
                `Total a pagar: ${moneda(totalPagar)}. ` +
                `Cada cuota: ${moneda(valorCuota)}.`;

        } else {

            explicacion.classList.add('hidden');

            textoCalculo.textContent = '';

        }

    }


    montoInput.addEventListener('input', calcular);

    interesInput.addEventListener('input', calcular);

    cuotasInput.addEventListener('input', calcular);

    frecuenciaInput.addEventListener('change', calcular);


    calcular();

});

</script>


</body>

</html>