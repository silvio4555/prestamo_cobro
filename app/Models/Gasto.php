<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    protected $table = 'gastos';

    protected $fillable = [
        'fecha',
        'categoria',
        'monto',
        'descripcion',
    ];

    protected $casts = [
        'fecha' => 'date',
        'monto' => 'decimal:2',
    ];

    /**
     * Categorías válidas de gasto.
     */
    public const CATEGORIAS = [
        'trabajador' => 'Pago al trabajador',
        'gasolina'   => 'Gasolina',
        'otro'       => 'Otro gasto',
    ];
}