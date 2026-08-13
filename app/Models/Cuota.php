<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Cuota extends Model
{
    protected $table = 'cuotas';

    protected $fillable = [
        'prestamo_id',
        'numero_cuota',
        'fecha_vencimiento',

        'valor_programado',

        'capital_programado',
        'interes_programado',

        'valor_pagado',

        'capital_pagado',
        'interes_pagado',

        'saldo_pendiente',

        'saldo_capital',
        'saldo_interes',

        'estado',
        'fecha_pago_completo',
        'dias_retraso',
    ];

    protected $casts = [
        'valor_programado' => 'decimal:2',

        'capital_programado' => 'decimal:2',
        'interes_programado' => 'decimal:2',

        'valor_pagado' => 'decimal:2',

        'capital_pagado' => 'decimal:2',
        'interes_pagado' => 'decimal:2',

        'saldo_pendiente' => 'decimal:2',

        'saldo_capital' => 'decimal:2',
        'saldo_interes' => 'decimal:2',

        'fecha_vencimiento' => 'date',
        'fecha_pago_completo' => 'date',

        'dias_retraso' => 'integer',
    ];

    /**
     * Préstamo al que pertenece la cuota.
     */
    public function prestamo(): BelongsTo
    {
        return $this->belongsTo(
            Prestamo::class,
            'prestamo_id'
        );
    }

    /**
     * Pagos aplicados a esta cuota.
     */
    public function aplicacionesPagos(): HasMany
    {
        return $this->hasMany(
            AplicacionPago::class,
            'cuota_id'
        );
    }


    /**
     * Días transcurridos desde la fecha de vencimiento hasta hoy.
     * 0 = vence hoy. Negativo = todavía no vence. Positivo = ya pasó la fecha.
     */
    public function diasDesdeVencimiento(): int
    {
        $hoy = Carbon::today()->startOfDay();

        $vencimiento = Carbon::parse($this->fecha_vencimiento)->startOfDay();

        return (int) floor(
            ($hoy->timestamp - $vencimiento->timestamp) / 86400
        );
    }
}