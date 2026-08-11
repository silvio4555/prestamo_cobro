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
    ];

    protected $casts = [
        'monto_aplicado' => 'decimal:2',
    ];

    public function pago(): BelongsTo
    {
        return $this->belongsTo(
            Pago::class,
            'pago_id'
        );
    }

    public function cuota(): BelongsTo
    {
        return $this->belongsTo(
            Cuota::class,
            'cuota_id' 
        );
    }
}