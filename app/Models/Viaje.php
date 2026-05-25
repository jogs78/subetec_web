<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Viaje extends Model
{
    // Aseguramos que reconozca la tabla de tu migración
    protected $table = 'viajes';

    protected $fillable = [
        'conductor',
        'marca',
        'modelo',
        'color',
        'placas',
        'asientos_disponibles',
        'origen',
        'destino',
        'salida',
        'llegada'
    ];

    /**
     * Obtiene el usuario que conduce/publicó este viaje.
     */
    public function chofer(): BelongsTo
    {
        // Se relaciona inversamente con Usuarios usando la columna 'conductor'
        return $this->belongsTo(Usuario::class, 'conductor');
    }
}