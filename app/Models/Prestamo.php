<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prestamo extends Model
{
    protected $table = 'prestamos';

    protected $fillable = [
        'cliente_id',
        'monto_prestado',
        'tasa_interes',
        'total_pagar',
        'frecuencia',
        'numero_cuotas',
        'valor_cuota',
        'fecha_prestamo',
        'fecha_primer_pago',
        'dias_plazo',
        'estado',
        'observaciones',
    ];

    protected $casts = [
        'monto_prestado' => 'decimal:2',
        'tasa_interes' => 'decimal:2',
        'total_pagar' => 'decimal:2',
        'valor_cuota' => 'decimal:2',
        'fecha_prestamo' => 'date',
        'fecha_primer_pago' => 'date',
        'dias_plazo' => 'integer',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function cuotas(): HasMany
    {
        return $this->hasMany(Cuota::class, 'prestamo_id');
    }


    /*
    |--------------------------------------------------------------------------
    | RESUMEN FINANCIERO
    |--------------------------------------------------------------------------
    | Requieren que la relación 'cuotas' venga cargada (eager load) para no
    | disparar consultas repetidas.
    */

    public function getTotalInteresAttribute()
    {
        return round(
            (float) $this->total_pagar - (float) $this->monto_prestado,
            2
        );
    }

    public function getTotalAbonadoAttribute()
    {
        return round(
            $this->cuotas->sum(fn ($cuota) => (float) $cuota->valor_pagado),
            2
        );
    }

    public function getSaldoPendienteAttribute()
    {
        return round(
            $this->cuotas->sum(fn ($cuota) => (float) $cuota->saldo_pendiente),
            2
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RESUMEN DE CUOTAS
    |--------------------------------------------------------------------------
    */

    public function getCuotasPagadasAttribute()
    {
        return $this->cuotas
            ->whereIn('estado', ['pagada', 'pagada_con_retraso'])
            ->count();
    }

    public function getCuotasParcialesAttribute()
    {
        return $this->cuotas->where('estado', 'parcial')->count();
    }

    public function getCuotasPendientesAttribute()
    {
        return $this->cuotas->where('estado', 'pendiente')->count();
    }

    public function getCuotasVencidasAttribute()
    {
        return $this->cuotas->where('estado', 'vencida')->count();
    }
}