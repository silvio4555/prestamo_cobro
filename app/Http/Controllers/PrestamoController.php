<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Prestamo;
use App\Models\Cuota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PrestamoController extends Controller
{
    /**
     * Mostrar formulario para crear un préstamo.
     */
    public function create(Cliente $cliente)
    {
        return view('prestamos.create', compact('cliente'));
    }

    /**
     * Guardar préstamo y generar cuotas.
     */
    public function store(Request $request, Cliente $cliente)
    {
        $datos = $request->validate([
            'monto_prestado' => 'required|numeric|min:0.01',
            'tasa_interes' => 'required|numeric|min:0|max:100',
            'frecuencia' => 'required|in:semanal,quincenal,mensual',
            'numero_cuotas' => 'required|integer|min:1',
            'fecha_prestamo' => 'required|date',
            'fecha_primer_pago' => 'required|date',
            'observaciones' => 'nullable|string|max:1000',
        ]);

        /*
        |--------------------------------------------------------------------------
        | DATOS DEL PRÉSTAMO
        |--------------------------------------------------------------------------
        */

        $montoPrestado = (float) $datos['monto_prestado'];

        $tasaInteres = (float) $datos['tasa_interes'];

        $numeroCuotas = (int) $datos['numero_cuotas'];


        /*
        |--------------------------------------------------------------------------
        | CÁLCULO DEL INTERÉS
        |--------------------------------------------------------------------------
        */

        $interesPorPeriodo = $montoPrestado * ($tasaInteres / 100);

        $interesTotal = $interesPorPeriodo * $numeroCuotas;

        $totalPagar = $montoPrestado + $interesTotal;

        $valorCuota = $totalPagar / $numeroCuotas;


        /*
        |--------------------------------------------------------------------------
        | CREAR PRÉSTAMO Y CUOTAS
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $cliente,
            $datos,
            $montoPrestado,
            $tasaInteres,
            $numeroCuotas,
            $totalPagar,
            $valorCuota,
            $interesPorPeriodo,
            $interesTotal
        ) {

            /*
            |--------------------------------------------------------------------------
            | CREAR PRÉSTAMO
            |--------------------------------------------------------------------------
            */

            $prestamo = Prestamo::create([
                'cliente_id' => $cliente->id,

                'monto_prestado' => $montoPrestado,

                'tasa_interes' => $tasaInteres,

                'total_pagar' => $totalPagar,

                'frecuencia' => $datos['frecuencia'],

                'numero_cuotas' => $numeroCuotas,

                'valor_cuota' => $valorCuota,

                'fecha_prestamo' => $datos['fecha_prestamo'],

                'fecha_primer_pago' => $datos['fecha_primer_pago'],

                'estado' => 'activo',

                'observaciones' => $datos['observaciones'] ?? null,
            ]);


            /*
            |--------------------------------------------------------------------------
            | GENERAR CUOTAS
            |--------------------------------------------------------------------------
            */

            $fechaPago = Carbon::parse($datos['fecha_primer_pago']);

            // Reparto de capital e interés por cuota (interés simple, cuotas iguales)
            $capitalPorCuota = round($montoPrestado / $numeroCuotas, 2);
            $interesPorCuota = round($interesPorPeriodo, 2);

            // Saldos "restantes" que se van descontando para poder
            // ajustar la última cuota y evitar diferencias de centavos.
            $saldoCapitalRestante = $montoPrestado;
            $saldoInteresRestante = $interesTotal;


            for ($i = 1; $i <= $numeroCuotas; $i++) {

                /*
                |--------------------------------------------------------------------------
                | Ajustar la última cuota para evitar diferencias de centavos.
                |--------------------------------------------------------------------------
                */

                if ($i === $numeroCuotas) {

                    $capitalEstaCuota = round($saldoCapitalRestante, 2);
                    $interesEstaCuota = round($saldoInteresRestante, 2);

                } else {

                    $capitalEstaCuota = $capitalPorCuota;
                    $interesEstaCuota = $interesPorCuota;
                }

                $valorEstaCuota = round($capitalEstaCuota + $interesEstaCuota, 2);


                $saldoCapitalRestante = round(
                    $saldoCapitalRestante - $capitalEstaCuota,
                    2
                );

                $saldoInteresRestante = round(
                    $saldoInteresRestante - $interesEstaCuota,
                    2
                );


                /*
                |--------------------------------------------------------------------------
                | Crear cuota
                |--------------------------------------------------------------------------
                */

                Cuota::create([
                    'prestamo_id' => $prestamo->id,

                    'numero_cuota' => $i,

                    'fecha_vencimiento' => $fechaPago->format('Y-m-d'),

                    // Totales
                    'valor_programado' => $valorEstaCuota,
                    'valor_pagado' => 0,
                    'saldo_pendiente' => $valorEstaCuota,

                    // Desglose capital
                    'capital_programado' => $capitalEstaCuota,
                    'capital_pagado' => 0,
                    'saldo_capital' => $capitalEstaCuota,

                    // Desglose interés
                    'interes_programado' => $interesEstaCuota,
                    'interes_pagado' => 0,
                    'saldo_interes' => $interesEstaCuota,

                    'estado' => 'pendiente',

                    'fecha_pago_completo' => null,

                    'dias_retraso' => 0,
                ]);


                /*
                |--------------------------------------------------------------------------
                | Calcular siguiente fecha
                |--------------------------------------------------------------------------
                */

                if ($datos['frecuencia'] === 'semanal') {

                    $fechaPago->addWeek();

                } elseif ($datos['frecuencia'] === 'quincenal') {

                    $fechaPago->addDays(15);

                } elseif ($datos['frecuencia'] === 'mensual') {

                    $fechaPago->addMonth();
                }
            }
        });


        /*
        |--------------------------------------------------------------------------
        | REDIRECCIÓN
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('clientes.show', $cliente)
            ->with(
                'success',
                'Préstamo registrado correctamente. Las cuotas fueron generadas.'
            );
    }


    /**
     * Mostrar detalle del préstamo.
     */
    public function show(Prestamo $prestamo)
    {
        $prestamo->load([
            'cliente',
            'cuotas'
        ]);

        return view(
            'prestamos.show',
            compact('prestamo')
        );
    }


    /**
     * Mostrar formulario para editar.
     */
    public function edit(Prestamo $prestamo)
    {
        $prestamo->load('cliente');

        return view(
            'prestamos.edit',
            compact('prestamo')
        );
    }


    /**
     * Actualizar préstamo.
     */
    public function update(
        Request $request,
        Prestamo $prestamo
    ) {

        $datos = $request->validate([
            'estado' => 'required|in:activo,pagado,vencido,cancelado',

            'observaciones' => 'nullable|string|max:1000',
        ]);


        $prestamo->update([
            'estado' => $datos['estado'],

            'observaciones' => $datos['observaciones'] ?? null,
        ]);


        return redirect()
            ->route('prestamos.show', $prestamo)
            ->with(
                'success',
                'Préstamo actualizado correctamente.'
            );
    }


    /**
     * Cancelar préstamo.
     */
    public function destroy(Prestamo $prestamo)
    {
        $prestamo->update([
            'estado' => 'cancelado',
        ]);


        return redirect()
            ->route(
                'clientes.show',
                $prestamo->cliente_id
            )
            ->with(
                'success',
                'Préstamo cancelado correctamente.'
            );
    }
}