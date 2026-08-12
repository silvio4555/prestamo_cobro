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
        $hoy = Carbon::today();

        $cuotas = Cuota::whereIn('estado', [
                'pendiente',
                'parcial',
                'vencida',
            ])
            ->whereDate('fecha_vencimiento', '<', $hoy)
            ->where('saldo_pendiente', '>', 0)
            ->get();


        $actualizadas = 0;


        foreach ($cuotas as $cuota) {

            $fechaVencimiento = Carbon::parse(
                $cuota->fecha_vencimiento
            );


            $diasRetraso = $fechaVencimiento->diffInDays($hoy);


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