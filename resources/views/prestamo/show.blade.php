<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Detalle del préstamo</title>

@vite(['resources/css/app.css','resources/js/app.js'])

</head>

<body class="bg-gray-100">

<div class="max-w-7xl mx-auto py-10">

<div class="bg-white rounded-xl shadow">

<div class="bg-blue-600 text-white p-6">

<h1 class="text-3xl font-bold">

Detalle del préstamo

</h1>

<p>

Cliente:

<strong>{{ $prestamo->cliente->nombre }}</strong>

</p>

</div>

<div class="grid grid-cols-2 gap-6 p-6">

<div>

<strong>Monto prestado</strong>

<p>$ {{ number_format($prestamo->monto_prestado,2) }}</p>

</div>

<div>

<strong>Interés</strong>

<p>{{ $prestamo->interes }} %</p>

</div>

<div>

<strong>Total a pagar</strong>

<p>$ {{ number_format($prestamo->total_pagar,2) }}</p>

</div>

<div>

<strong>Estado</strong>

<p>{{ ucfirst($prestamo->estado) }}</p>

</div>

<div>

<strong>Tipo</strong>

<p>{{ $prestamo->tipo_pago }}</p>

</div>

<div>

<strong>Cuotas</strong>

<p>{{ $prestamo->numero_cuotas }}</p>

</div>

</div>

</div>

<div class="bg-white rounded-xl shadow mt-8">

<div class="p-6 border-b">

<h2 class="text-2xl font-bold">

Cuotas

</h2>

</div>

<table class="w-full">

<thead class="bg-gray-100">

<tr>

<th class="p-4">#</th>

<th class="p-4">Fecha</th>

<th class="p-4">Valor</th>

<th class="p-4">Saldo</th>

<th class="p-4">Estado</th>

<th class="p-4">Acción</th>

</tr>

</thead>

<tbody>

@foreach($prestamo->cuotas as $cuota)

<tr class="border-b text-center">

<td class="p-4">

{{ $cuota->numero_cuota }}

</td>

<td>

{{ $cuota->fecha_vencimiento }}

</td>

<td>

$ {{ number_format($cuota->valor_cuota,2) }}

</td>

<td>

$ {{ number_format($cuota->saldo_pendiente,2) }}

</td>

<td>

{{ ucfirst($cuota->estado) }}

</td>

<td>

<a
href="{{ route('cobros.create',$cuota) }}"
class="bg-green-600 text-white px-4 py-2 rounded">

Pagar

</a>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

</body>

</html>