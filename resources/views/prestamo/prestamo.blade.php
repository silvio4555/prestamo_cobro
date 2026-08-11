<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Nuevo préstamo</title>

 @vite(['resources/css/app.css','resources/js/app.js'])

</head>

<body class="bg-gray-100">

<div class="max-w-4xl mx-auto py-10">

<div class="bg-white rounded-xl shadow">

<div class="bg-blue-600 text-white p-6">

<h1 class="text-2xl font-bold">

Nuevo préstamo

</h1>

<p>

Cliente:

<strong>{{ $cliente->nombre }}</strong>

</p>

</div>

<form
action="{{ route('prestamos.store',$cliente) }}"
method="POST"
class="p-8 space-y-6">

@csrf

<div>

<label>Monto prestado</label>

<input
type="number"
step="0.01"
name="monto_prestado"
class="w-full border rounded-lg p-3"
required>

</div>

<div>

<label>Interés (%)</label>

<input
type="number"
step="0.01"
name="interes"
class="w-full border rounded-lg p-3"
required>

</div>

<div>

<label>Tipo de pago</label>

<select
name="tipo_pago"
class="w-full border rounded-lg p-3">

<option value="Semanal">

Semanal

</option>

<option value="Mensual">

Mensual

</option>

</select>

</div>

<div>

<label>Número de cuotas</label>

<input
type="number"
name="numero_cuotas"
class="w-full border rounded-lg p-3"
required>

</div>

<div>

<label>Fecha del primer pago</label>

<input
type="date"
name="fecha_inicio"
class="w-full border rounded-lg p-3"
required>

</div>

<div class="flex justify-end gap-4">

<a
href="{{ route('clientes.show',$cliente) }}"
class="bg-gray-300 px-5 py-3 rounded">

Cancelar

</a>

<button
class="bg-blue-600 text-white px-6 py-3 rounded">

Guardar préstamo

</button>

</div>

</form>

</div>

</div>

</body>

</html>