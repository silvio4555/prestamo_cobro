<?php

namespace App\Console\Commands;

use App\Models\Cuota;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ActualizarCuotasVencidas extends Command
{
    /**
     * Nombre y descripción del comando.
     */
    protected $signature = 'cuotas:actualizar-vencidas';

    protected $description = 'Actualiza las cuotas vencidas y calcula los días de retraso';


    /**
     * Ejecutar el comando.
     */
    public function handle()
    {
        $hoy = Carbon::today()->startOfDay();

        // Cargamos el préstamo de cada cuota para conocer su dias_plazo particular.
        $cuotas = Cuota::with('prestamo')
            ->whereIn('estado', [
                'pendiente',
                'parcial',
                'vencida',
            ])
            ->whereDate('fecha_vencimiento', '<', $hoy)
            ->where('saldo_pendiente', '>', 0)
            ->get();


        $actualizadas = 0;


        foreach ($cuotas as $cuota) {

            $diasPlazo = (int) ($cuota->prestamo->dias_plazo ?? 0);

            $fechaVencimiento = Carbon::parse(
                $cuota->fecha_vencimiento
            )->startOfDay();

            // Días corridos desde el vencimiento (1 = un día después, etc).
            $diasTranscurridos = (int) floor(
                ($hoy->timestamp - $fechaVencimiento->timestamp) / 86400
            );


            // Todavía dentro del plazo de gracia ("En plazo") — no se marca vencida.
            if ($diasTranscurridos <= $diasPlazo) {
                continue;
            }


            // Ya se agotó el plazo de gracia: el retraso empieza a contar desde aquí.
            $diasRetraso = $diasTranscurridos - $diasPlazo;


            $cuota->update([
                'estado' => 'vencida',
                'dias_retraso' => $diasRetraso,
            ]);


            $actualizadas++;
        }


        $this->info(
            "Cuotas vencidas actualizadas: {$actualizadas}"
        );


        return Command::SUCCESS;
    }
}