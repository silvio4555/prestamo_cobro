<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
        'nombre',
        'documento',
        'telefono',
        'direccion',
        'correo',
        'estado',
    ];

    public function prestamos(): HasMany
    {
        return $this->hasMany(Prestamo::class, 'cliente_id');
    }
}