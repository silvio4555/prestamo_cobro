<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pago extends Model
{
    protected $table = 'pagos';

    protected $fillable = [
        'monto',
        'fecha_pago',
        'metodo_pago',
        'observaciones',
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'fecha_pago' => 'date',
    ];

    public function aplicaciones(): HasMany
    {
        return $this->hasMany(
            AplicacionPago::class,
            'pago_id'
        );
    }
}