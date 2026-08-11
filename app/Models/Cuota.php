<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cuota extends Model
{
    protected $table = 'cuotas';

    protected $fillable = [
        'prestamo_id',
        'numero_cuota',
        'fecha_vencimiento',
        'valor_programado',
        'valor_pagado',
        'saldo_pendiente',
        'estado',
        'fecha_pago_completo',
        'dias_retraso',
    ];

    protected $casts = [
        'fecha_vencimiento' => 'date',
        'fecha_pago_completo' => 'date',
        'valor_programado' => 'decimal:2',
        'valor_pagado' => 'decimal:2',
        'saldo_pendiente' => 'decimal:2',
    ];

    public function prestamo(): BelongsTo
    {
        return $this->belongsTo(Prestamo::class, 'prestamo_id');
    }

    public function aplicacionesPagos(): HasMany
    {
        return $this->hasMany(
            AplicacionPago::class,
            'cuota_id'
        );
    }
}