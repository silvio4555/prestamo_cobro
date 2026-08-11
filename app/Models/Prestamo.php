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
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function cuotas(): HasMany
    {
        return $this->hasMany(Cuota::class, 'prestamo_id');
    }
}