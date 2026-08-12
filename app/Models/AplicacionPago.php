<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AplicacionPago extends Model
{
    protected $table = 'aplicaciones_pagos';

    protected $fillable = [
        'pago_id',
        'cuota_id',
        'monto_aplicado',
        'monto_capital',
        'monto_interes',
    ];

    protected $casts = [
        'monto_aplicado' => 'decimal:2',
        'monto_capital' => 'decimal:2',
        'monto_interes' => 'decimal:2',
    ];

    /**
     * Pago al que pertenece esta aplicación.
     */
    public function pago(): BelongsTo
    {
        return $this->belongsTo(
            Pago::class,
            'pago_id'
        );
    }

    /**
     * Cuota a la que se aplicó el pago.
     */
    public function cuota(): BelongsTo
    {
        return $this->belongsTo(
            Cuota::class,
            'cuota_id'
        );
    }
}