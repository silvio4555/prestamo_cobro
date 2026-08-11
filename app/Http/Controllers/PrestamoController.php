<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Prestamo;
use App\Models\Cuota;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PrestamoController extends Controller
{
    public function create(Cliente $cliente)
    {
        return view('prestamos.create', compact('cliente'));
    }

    public function store(Request $request, Cliente $cliente)
    {
        $request->validate([
            'monto_prestado' => 'required|numeric|min:1',
            'interes' => 'required|numeric|min:0',
            'tipo_pago' => 'required|in:Semanal,Mensual',
            'numero_cuotas' => 'required|integer|min:1',
            'fecha_inicio' => 'required|date',
        ]);

        $total = $request->monto_prestado + ($request->monto_prestado * $request->interes / 100);

        $valorCuota = round($total / $request->numero_cuotas, 2);

        $prestamo = Prestamo::create([
            'cliente_id' => $cliente->id,
            'monto_prestado' => $request->monto_prestado,
            'interes' => $request->interes,
            'total_pagar' => $total,
            'tipo_pago' => $request->tipo_pago,
            'numero_cuotas' => $request->numero_cuotas,
            'fecha_inicio' => $request->fecha_inicio,
            'estado' => 'activo',
        ]);

        $fecha = Carbon::parse($request->fecha_inicio);

        for ($i = 1; $i <= $request->numero_cuotas; $i++) {

            Cuota::create([
                'prestamo_id' => $prestamo->id,
                'numero_cuota' => $i,
                'fecha_vencimiento' => $fecha->copy(),
                'valor_cuota' => $valorCuota,
                'saldo_pendiente' => $valorCuota,
                'estado' => 'pendiente',
            ]);

            if ($request->tipo_pago == 'Semanal') {
                $fecha->addWeek();
            } else {
                $fecha->addMonth();
            }
        }

        return redirect()->route('prestamos.show', $prestamo);
    }

    public function show(Prestamo $prestamo)
    {
        $prestamo->load('cliente', 'cuotas');

        return view('prestamos.show', compact('prestamo'));
    }
}