<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http; // 📌 Para consumir la API de mapas de OpenStreetMap
use Inertia\Inertia;

class ViajeMonitoreoController extends Controller
{
    /**
     * Muestra la pantalla dividida inicial con el machote de Inertia
     */
    public function index()
    {
        return Inertia::render('Viajes/Monitoreo');
    }

    /**
     * Valida las credenciales de acceso al viaje y calcula la ruta dinámica
     */
    public function verificarAcceso(Request $request)
    {
        // Validación de datos de entrada
        $request->validate([
            'viaje_id' => 'required|integer',
            'nombre' => 'required|string|max:255',
        ]);

        $viajeId = $request->input('viaje_id');
        $nombreBusqueda = trim($request->input('nombre'));

        // 1. Buscamos el viaje con los datos del conductor asociado
        $viaje = DB::table('viajes as v')
            ->join('usuarios as u', 'v.conductor', '=', 'u.id')
            ->select(
                'v.id', 'v.origen', 'v.destino', 'v.salida', 'v.asientos_disponibles', 'v.marca', 'v.modelo',
                'u.id as conductor_id', 'u.nombre as nombre_conductor'
            )
            ->where('v.id', $viajeId)
            ->first();

        // Si el viaje no existe en la base de datos
        if (!$viaje) {
            return response()->json(['error' => 'El ID del viaje no existe.'], 404);
        }

        // 📌 CORRECCIÓN: Búsqueda parcial y flexible del nombre sin importar mayúsculas/minúsculas
        // Verifica si el texto ingresado coincide con parte del nombre del conductor
        $esConductor = (strpos(strtolower($viaje->nombre_conductor), strtolower($nombreBusqueda)) !== false);
        
        // Verifica si coincide con parte del nombre de algún pasajero registrado en el viaje
        $esPasajero = DB::table('usuario_viaje as uv')
            ->join('usuarios as u', 'uv.usuario_id', '=', 'u.id')
            ->where('uv.viaje_id', $viajeId)
            ->where('u.nombre', 'LIKE', "%{$nombreBusqueda}%")
            ->exists();

        // Si el nombre no coincide con ningún tripulante del viaje
        if (!$esConductor && !$esPasajero) {
            return response()->json(['error' => 'El nombre no coincide con ningún conductor o pasajero de este viaje.'], 403);
        }

        // 3. Obtenemos la lista de todos los pasajeros confirmados para el panel informativo izquierdo
        $pasajeros = DB::table('usuario_viaje as uv')
            ->join('usuarios as u', 'uv.usuario_id', '=', 'u.id')
            ->where('uv.viaje_id', $viajeId)
            ->select('u.nombre')
            ->get();

        // 4. Coordenadas optimizadas: Origen fijo (Tec de Tuxtla) y Destino geocodificado dinámicamente
        $coordenadas = [
            'origen' => [
                'lat' => 16.7483, 
                'lng' => -93.1517
            ], 
            'destino' => $this->buscarCoordenadaDestino($viaje->destino)
        ];

        // Retornamos la respuesta en formato JSON para que Axios la procese en Vue
        return response()->json([
            'success' => true,
            'viaje' => $viaje,
            'pasajeros' => $pasajeros,
            'coordenadas' => $coordenadas,
            'rol_usuario' => $esConductor ? 'Conductor' : 'Pasajero'
        ]);
    }

    /**
     * Función auxiliar privada para geocodificar el texto del destino usando OpenStreetMap (Nominatim)
     */
    private function buscarCoordenadaDestino($destinoTexto)
    {
        // Coordenada de respaldo por si el buscador externo no encuentra la ubicación (Chiapa de Corzo)
        $coordenadaDestino = ['lat' => 16.7082, 'lng' => -93.0154];

        try {
            // Hacemos la consulta HTTP al servicio de OpenStreetMap añadiendo contexto de Chiapas
            $respuesta = Http::withHeaders(['User-Agent' => 'SubeTecApp'])
                ->get('https://nominatim.openstreetmap.org/search', [
                    'q' => $destinoTexto . ', Chiapas, Mexico',
                    'format' => 'json',
                    'limit' => 1
                ])->json();

            // Si el servicio devuelve un resultado válido, extraemos la latitud y longitud
            if (!empty($respuesta)) {
                $coordenadaDestino['lat'] = (float) $respuesta[0]['lat'];
                $coordenadaDestino['lng'] = (float) $respuesta[0]['lon'];
            }
        } catch (\Exception $e) {
            // Si la API externa se cae, se usa la coordenada de respaldo de forma segura
        }

        return $coordenadaDestino;
    }
}