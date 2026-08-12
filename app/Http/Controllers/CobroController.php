<?php

namespace App\Http\Controllers;

use App\Models\Cuota;
use App\Models\Pago;
use App\Models\AplicacionPago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CobroController extends Controller
{
    /**
     * Mostrar formulario para registrar un pago.
     */
    public function create(Cuota $cuota)
    {
        // Recargar la cuota directamente desde MySQL
        $cuota->refresh();

        // Cargar las relaciones necesarias
        $cuota->load([
            'prestamo.cliente',
            'aplicacionesPagos.pago',
        ]);

        return view('cobros.create', [
            'cuota' => $cuota,
        ]);
    }


    /**
     * Registrar un pago.
     */
    public function store(Request $request, Cuota $cuota)
    {
        $request->validate([
            'monto_capital' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'monto_interes' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'fecha_pago' => [
                'required',
                'date',
            ],

            'metodo_pago' => [
                'required',
                'in:efectivo,transferencia,otro',
            ],

            'observaciones' => [
                'nullable',
                'string',
            ],
        ]);

        $montoCapital = (float) ($request->monto_capital ?? 0);
        $montoInteres = (float) ($request->monto_interes ?? 0);

        $totalAbono = $montoCapital + $montoInteres;

        /*
        |--------------------------------------------------------------------------
        | Verificar que exista algún abono
        |--------------------------------------------------------------------------
        */

        if ($totalAbono <= 0) {
            return back()
                ->withErrors([
                    'monto_capital' => 'Debes ingresar un monto a capital, a interés o a ambos.',
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | Recargar cuota para trabajar con datos actuales
        |--------------------------------------------------------------------------
        */

        $cuota->refresh();


        $saldoCapital = (float) $cuota->saldo_capital;
        $saldoInteres = (float) $cuota->saldo_interes;


        /*
        |--------------------------------------------------------------------------
        | No permitir pagar más del saldo
        |--------------------------------------------------------------------------
        */

        if ($montoCapital > $saldoCapital) {
            return back()
                ->withErrors([
                    'monto_capital' =>
                        'El abono a capital no puede superar el saldo de capital de $'
                        . number_format($saldoCapital, 2, ',', '.'),
                ])
                ->withInput();
        }


        if ($montoInteres > $saldoInteres) {
            return back()
                ->withErrors([
                    'monto_interes' =>
                        'El abono a interés no puede superar el saldo de interés de $'
                        . number_format($saldoInteres, 2, ',', '.'),
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | Registrar todo en una transacción
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $cuota,
            $montoCapital,
            $montoInteres,
            $totalAbono,
            $request
        ) {

            /*
            |--------------------------------------------------------------------------
            | Crear pago
            |--------------------------------------------------------------------------
            */

            $pago = Pago::create([
                'monto' => $totalAbono,
                'fecha_pago' => $request->fecha_pago,
                'metodo_pago' => $request->metodo_pago,
                'observaciones' => $request->observaciones,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Crear aplicación del pago
            |--------------------------------------------------------------------------
            */

            AplicacionPago::create([
                'pago_id' => $pago->id,
                'cuota_id' => $cuota->id,
                'monto_aplicado' => $totalAbono,
                'monto_capital' => $montoCapital,
                'monto_interes' => $montoInteres,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Nuevos valores
            |--------------------------------------------------------------------------
            */

            $nuevoCapitalPagado =
                (float) $cuota->capital_pagado + $montoCapital;

            $nuevoInteresPagado =
                (float) $cuota->interes_pagado + $montoInteres;


            $nuevoSaldoCapital =
                max(
                    0,
                    (float) $cuota->capital_programado - $nuevoCapitalPagado
                );


            $nuevoSaldoInteres =
                max(
                    0,
                    (float) $cuota->interes_programado - $nuevoInteresPagado
                );


            $nuevoValorPagado =
                (float) $cuota->valor_pagado + $totalAbono;


            $nuevoSaldoPendiente =
                $nuevoSaldoCapital + $nuevoSaldoInteres;


            /*
            |--------------------------------------------------------------------------
            | Estado de la cuota
            |--------------------------------------------------------------------------
            */

            if ($nuevoSaldoCapital <= 0 && $nuevoSaldoInteres <= 0) {

                $estado = 'pagada';

                $fechaPagoCompleto = $request->fecha_pago;

            } else {

                $estado = 'parcial';

                $fechaPagoCompleto = null;
            }


            /*
            |--------------------------------------------------------------------------
            | Actualizar cuota
            |--------------------------------------------------------------------------
            */

            $cuota->update([
                'capital_pagado' => $nuevoCapitalPagado,
                'interes_pagado' => $nuevoInteresPagado,

                'valor_pagado' => $nuevoValorPagado,

                'saldo_capital' => $nuevoSaldoCapital,
                'saldo_interes' => $nuevoSaldoInteres,

                'saldo_pendiente' => $nuevoSaldoPendiente,

                'estado' => $estado,

                'fecha_pago_completo' => $fechaPagoCompleto,
            ]);
        });


        return redirect()
            ->route('prestamos.show', $cuota->prestamo_id)
            ->with('success', 'Pago registrado correctamente.');
    }
}