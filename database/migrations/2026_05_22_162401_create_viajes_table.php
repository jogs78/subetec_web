<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('viajes', function (Blueprint $table) {
            $table->id();
            // Llave foránea del conductor
            $table->foreignId('conductor')->references('id')->on('usuarios')->onDelete('cascade');
            
            // Datos del vehículo
            $table->string('marca');
            $table->string('modelo');
            $table->string('color');
            $table->string('placas');
            $table->integer('asientos_disponibles'); // Lugares disponibles reales para pasajeros
            
            // Ruta y Horarios
            $table->string('origen');
            $table->string('destino');
            $table->dateTime('salida');
            $table->dateTime('llegada');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('viajes');
    }
};
