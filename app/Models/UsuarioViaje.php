<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioViaje extends Model
{
    /** @use HasFactory<\Database\Factories\UsuarioViajeFactory> */
    use HasFactory;
    protected $table = 'usuario_viaje';
}
