<?php

namespace App\Http\Controllers;

use App\Models\Cuota;
use App\Models\Pago;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Panel de cobros: qué hay que cobrar hoy, qué está vencido
     * y qué clientes tienen deudas pendientes.
     */
    public function index()
    {
        $hoy = Carbon::today()->startOfDay();

        /*
        |--------------------------------------------------------------------------
        | CUOTAS CON SALDO PENDIENTE
        |--------------------------------------------------------------------------
        | Se calcula en vivo (igual que en prestamos.show) en lugar de confiar
        | únicamente en el estado "vencida", por si el comando
        | cuotas:actualizar-vencidas todavía no corrió hoy.
        */

        $cuotas = Cuota::with(['prestamo.cliente'])
            ->whereIn('estado', ['pendiente', 'parcial', 'vencida'])
            ->where('saldo_pendiente', '>', 0)
            ->get()
            ->filter(fn ($cuota) => $cuota->prestamo && $cuota->prestamo->cliente);

        $cobrosHoy = collect();
        $cobrosVencidos = collect();

        foreach ($cuotas as $cuota) {

            $diasPlazo = (int) ($cuota->prestamo->dias_plazo ?? 0);
            $diasDesdeVencimiento = $cuota->diasDesdeVencimiento();

            if ($diasDesdeVencimiento > $diasPlazo) {

                $cobrosVencidos->push($cuota);

            } elseif ($cuota->fecha_vencimiento->isSameDay($hoy)) {

                $cobrosHoy->push($cuota);
            }
        }

        // Cobros vencidos: los más atrasados primero.
        $cobrosVencidos = $cobrosVencidos
            ->sortByDesc(fn ($cuota) => $cuota->diasDesdeVencimiento())
            ->values();

        $cobrosHoy = $cobrosHoy->values();


        /*
        |--------------------------------------------------------------------------
        | TOTALES
        |--------------------------------------------------------------------------
        */

        $totalHoy = $cobrosHoy->sum(fn ($cuota) => (float) $cuota->saldo_pendiente);

        $totalVencido = $cobrosVencidos->sum(fn ($cuota) => (float) $cuota->saldo_pendiente);

        $cobradoHoy = (float) Pago::whereDate('fecha_pago', $hoy)->sum('monto');


        /*
        |--------------------------------------------------------------------------
        | CLIENTES QUE DEBEN PAGAR (hoy o vencido)
        |--------------------------------------------------------------------------
        */

        $clientesConDeuda = $cobrosHoy->concat($cobrosVencidos)
            ->groupBy(fn ($cuota) => $cuota->prestamo->cliente_id)
            ->map(function ($cuotasCliente) {

                $cliente = $cuotasCliente->first()->prestamo->cliente;

                $tieneVencidas = $cuotasCliente->contains(
                    fn ($cuota) => $cuota->diasDesdeVencimiento() > (int) ($cuota->prestamo->dias_plazo ?? 0)
                );

                return (object) [
                    'cliente' => $cliente,
                    'cuotas' => $cuotasCliente
                        ->sortByDesc(fn ($cuota) => $cuota->diasDesdeVencimiento())
                        ->values(),
                    'total_adeudado' => $cuotasCliente->sum(fn ($cuota) => (float) $cuota->saldo_pendiente),
                    'tiene_vencidas' => $tieneVencidas,
                ];
            })
            ->sortByDesc(fn ($item) => $item->tiene_vencidas ? 1 : 0)
            ->values();


        return view('dashboard.index', compact(
            'hoy',
            'cobrosHoy',
            'cobrosVencidos',
            'totalHoy',
            'totalVencido',
            'cobradoHoy',
            'clientesConDeuda'
        ));
    }
}