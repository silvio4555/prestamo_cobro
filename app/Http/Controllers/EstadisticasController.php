<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Models\Cuota;
use App\Models\Cliente;

class EstadisticasController extends Controller
{
    /**
     * Solo sirve la página. Los datos se cargan por AJAX desde data().
     */
    public function index()
    {
        return view('estadisticas.index');
    }

    /**
     * Devuelve en JSON todos los datos que consume la página de estadísticas:
     * KPIs de cartera, distribución por estado, antigüedad de mora,
     * top clientes con deuda y las cuotas más atrasadas.
     */
    public function data()
    {
        /*
        |--------------------------------------------------------------------------
        | KPIs DE CARTERA
        |--------------------------------------------------------------------------
        */

        $carteraTotal = (float) Cuota::where('saldo_pendiente', '>', 0)->sum('saldo_pendiente');

        $carteraVencida = (float) Cuota::where('estado', 'vencida')
            ->where('saldo_pendiente', '>', 0)
            ->sum('saldo_pendiente');

        $carteraSana = round($carteraTotal - $carteraVencida, 2);

        $porcentajeVencida = $carteraTotal > 0
            ? round(($carteraVencida / $carteraTotal) * 100, 1)
            : 0;

        $totalPrestamos = Prestamo::count();
        $prestamosActivos = Prestamo::where('estado', 'activo')->count();
        $prestamosVencidos = Prestamo::where('estado', 'vencido')->count();

        $clientesConPrestamo = Prestamo::distinct('cliente_id')->count('cliente_id');


        /*
        |--------------------------------------------------------------------------
        | DISTRIBUCIÓN DE PRÉSTAMOS POR ESTADO
        |--------------------------------------------------------------------------
        */

        $prestamosPorEstadoRaw = Prestamo::selectRaw('estado, COUNT(*) as cantidad, SUM(monto_prestado) as monto')
            ->groupBy('estado')
            ->get()
            ->keyBy('estado');

        $prestamosPorEstado = collect(['activo', 'pagado', 'vencido', 'cancelado'])
            ->map(function ($estado) use ($prestamosPorEstadoRaw) {
                $fila = $prestamosPorEstadoRaw->get($estado);

                return [
                    'estado' => ucfirst($estado),
                    'cantidad' => (int) ($fila->cantidad ?? 0),
                    'monto' => (float) ($fila->monto ?? 0),
                ];
            })
            ->values();


        /*
        |--------------------------------------------------------------------------
        | ANTIGÜEDAD DE LA MORA
        |--------------------------------------------------------------------------
        */

        $rangosMora = [
            '0-7 días' => [0, 7],
            '8-15 días' => [8, 15],
            '16-30 días' => [16, 30],
            '+30 días' => [31, null],
        ];

        $antiguedadMora = collect($rangosMora)->map(function ($rango, $etiqueta) {

            $query = Cuota::where('estado', 'vencida')
                ->where('saldo_pendiente', '>', 0)
                ->where('dias_retraso', '>=', $rango[0]);

            if ($rango[1] !== null) {
                $query->where('dias_retraso', '<=', $rango[1]);
            }

            return [
                'etiqueta' => $etiqueta,
                'cantidad' => (clone $query)->count(),
                'monto' => (float) (clone $query)->sum('saldo_pendiente'),
            ];
        })->values();


        /*
        |--------------------------------------------------------------------------
        | TOP CLIENTES CON MAYOR DEUDA
        |--------------------------------------------------------------------------
        */

        $topClientes = Cliente::query()
            ->withSum(['prestamos as saldo_pendiente' => function ($query) {
                $query->join('cuotas', 'cuotas.prestamo_id', '=', 'prestamos.id')
                    ->where('cuotas.saldo_pendiente', '>', 0);
            }], 'cuotas.saldo_pendiente')
            ->having('saldo_pendiente', '>', 0)
            ->orderByDesc('saldo_pendiente')
            ->limit(10)
            ->get()
            ->map(fn ($cliente) => [
                'nombre' => $cliente->nombre,
                'saldo_pendiente' => (float) $cliente->saldo_pendiente,
            ]);


        /*
        |--------------------------------------------------------------------------
        | CUOTAS MÁS ATRASADAS
        |--------------------------------------------------------------------------
        */

        $cuotasVencidas = Cuota::with(['prestamo.cliente'])
            ->where('estado', 'vencida')
            ->where('saldo_pendiente', '>', 0)
            ->orderByDesc('dias_retraso')
            ->limit(10)
            ->get()
            ->filter(fn ($cuota) => $cuota->prestamo && $cuota->prestamo->cliente)
            ->map(fn ($cuota) => [
                'cliente' => $cuota->prestamo->cliente->nombre,
                'numero_cuota' => $cuota->numero_cuota,
                'dias_retraso' => $cuota->dias_retraso,
                'saldo_pendiente' => (float) $cuota->saldo_pendiente,
            ])
            ->values();


        return response()->json([
            'kpis' => [
                'cartera_total' => $carteraTotal,
                'cartera_sana' => $carteraSana,
                'cartera_vencida' => $carteraVencida,
                'porcentaje_vencida' => $porcentajeVencida,
                'total_prestamos' => $totalPrestamos,
                'prestamos_activos' => $prestamosActivos,
                'prestamos_vencidos' => $prestamosVencidos,
                'clientes_con_prestamo' => $clientesConPrestamo,
            ],
            'prestamos_por_estado' => $prestamosPorEstado,
            'antiguedad_mora' => $antiguedadMora,
            'top_clientes' => $topClientes,
            'cuotas_vencidas' => $cuotasVencidas,
        ]);
    }
}