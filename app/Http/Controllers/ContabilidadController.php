<?php

namespace App\Http\Controllers;

use App\Models\Gasto;
use App\Models\Pago;
use App\Models\Prestamo;
use Carbon\Carbon;

class ContabilidadController extends Controller
{
    public function index()
    {
        $hoy = Carbon::today();

        // Semana calendario: lunes a domingo.
        $inicioSemana = $hoy->copy()->startOfWeek(Carbon::MONDAY);
        $finSemana = $hoy->copy()->endOfWeek(Carbon::SUNDAY);

        $inicioMes = $hoy->copy()->startOfMonth();
        $finMes = $hoy->copy()->endOfMonth();


        /*
        |--------------------------------------------------------------------------
        | INGRESOS
        |--------------------------------------------------------------------------
        */

        $cobradoSemana = (float) Pago::whereBetween('fecha_pago', [$inicioSemana, $finSemana])
            ->sum('monto');

        $cobradoMes = (float) Pago::whereBetween('fecha_pago', [$inicioMes, $finMes])
            ->sum('monto');

        $prestadoSemana = (float) Prestamo::whereBetween('fecha_prestamo', [$inicioSemana, $finSemana])
            ->sum('monto_prestado');

        $prestadoMes = (float) Prestamo::whereBetween('fecha_prestamo', [$inicioMes, $finMes])
            ->sum('monto_prestado');


        /*
        |--------------------------------------------------------------------------
        | EGRESOS (del mes actual)
        |--------------------------------------------------------------------------
        */

        $gastosMes = Gasto::whereBetween('fecha', [$inicioMes, $finMes])->get();

        $gastadoMes = (float) $gastosMes->sum('monto');

        $trabajadorMes = (float) $gastosMes
            ->where('categoria', 'trabajador')
            ->sum('monto');

        $gasolinaMes = (float) $gastosMes
            ->where('categoria', 'gasolina')
            ->sum('monto');

        $otrosGastosMes = (float) $gastosMes
            ->where('categoria', 'otro')
            ->sum('monto');


        /*
        |--------------------------------------------------------------------------
        | GANANCIA LIBRE MENSUAL
        |--------------------------------------------------------------------------
        | Lo cobrado en el mes menos lo gastado en el mes (trabajador, gasolina,
        | otros gastos). No incluye el capital prestado, porque ese dinero no
        | se pierde: sigue siendo cartera por cobrar.
        */

        $gananciaLibreMes = $cobradoMes - $gastadoMes;


        /*
        |--------------------------------------------------------------------------
        | ÚLTIMOS GASTOS REGISTRADOS
        |--------------------------------------------------------------------------
        */

        $ultimosGastos = Gasto::orderBy('fecha', 'desc')
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();


        return view('contabilidad.index', compact(
            'hoy',
            'inicioSemana',
            'finSemana',
            'inicioMes',
            'finMes',
            'cobradoSemana',
            'cobradoMes',
            'prestadoSemana',
            'prestadoMes',
            'gastadoMes',
            'trabajadorMes',
            'gasolinaMes',
            'otrosGastosMes',
            'gananciaLibreMes',
            'ultimosGastos'
        ));
    }
}