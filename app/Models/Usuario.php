<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usuario extends Model
{
    // ... Tus configuraciones actuales (table, fillable, etc.) ...

    /**
     * Obtiene los viajes publicados por el usuario como conductor.
     */
    public function viajes(): HasMany
    {
        // El primer parámetro es el modelo destino.
        // El segundo parámetro es la llave foránea personalizada en la tabla viajes ('conductor').
        return $this->hasMany(Viaje::class, 'conductor');
    }
}