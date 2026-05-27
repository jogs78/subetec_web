<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViajeMonitoreoController;

// Cambiamos el view('welcome') por el controlador
Route::get('/', [ViajeMonitoreoController::class, 'index']);

// Ruta para la validación por Axios
Route::post('/viajes/monitoreo/verificar', [ViajeMonitoreoController::class, 'verificarAcceso']);
