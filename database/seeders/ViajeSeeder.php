<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ViajeSeeder extends Seeder
{
    public function run(): void
    {
        // Definimos la fecha base solicitada (Viernes 29 de Mayo de 2026)
        $fechaBase = '2026-05-29';

        $viajes = [
            // 1. San Cristóbal - Mañana
            [
                'conductor' => 1, // Jorge Octavio
                'marca' => 'Chevrolet', 'modelo' => 'Aveo', 'color' => 'Gris Plata', 'placas' => 'DLN-452-C',
                'asientos_disponibles' => 3,
                'origen' => 'Tuxtla Gutiérrez (ITTG Campus I)', 'destino' => 'San Cristóbal de Las Casas',
                'salida' => Carbon::parse("$fechaBase 07:00:00"),
                'llegada' => Carbon::parse("$fechaBase 08:15:00"),
            ],
            // 2. San Cristóbal - Mediodía (Mismo destino, diferente hora y conductor)
            [
                'conductor' => 3,
                'marca' => 'Nissan', 'modelo' => 'March', 'color' => 'Azul', 'placas' => 'DPM-881-B',
                'asientos_disponibles' => 4,
                'origen' => 'Tuxtla Gutiérrez (Centro)', 'destino' => 'San Cristóbal de Las Casas',
                'salida' => Carbon::parse("$fechaBase 12:30:00"),
                'llegada' => Carbon::parse("$fechaBase 13:45:00"),
            ],
            // 3. San Cristóbal - Tarde (Mismo destino, salida nocturna/vespertina)
            [
                'conductor' => 2,
                'marca' => 'Volkswagen', 'modelo' => 'Vento', 'color' => 'Blanco', 'placas' => 'DRK-234-A',
                'asientos_disponibles' => 3,
                'origen' => 'Tuxtla Gutiérrez (ITTG Campus I)', 'destino' => 'San Cristóbal de Las Casas',
                'salida' => Carbon::parse("$fechaBase 16:00:00"),
                'llegada' => Carbon::parse("$fechaBase 17:15:00"),
            ],
            // 4. Chiapa de Corzo - Salida corta mediodía
            [
                'conductor' => 2, // Fulanito
                'marca' => 'Nissan', 'modelo' => 'Tsuru', 'color' => 'Blanco', 'placas' => 'DLD-772-B',
                'asientos_disponibles' => 4,
                'origen' => 'Tuxtla Gutiérrez (Campus II)', 'destino' => 'Chiapa de Corzo (Centro)',
                'salida' => Carbon::parse("$fechaBase 14:15:00"),
                'llegada' => Carbon::parse("$fechaBase 14:45:00"),
            ],
            // 5. Chiapa de Corzo - Salida corta tarde
            [
                'conductor' => 1, // Jorge Octavio viaja local
                'marca' => 'Chevrolet', 'modelo' => 'Aveo', 'color' => 'Gris Plata', 'placas' => 'DLN-452-C',
                'asientos_disponibles' => 3,
                'origen' => 'Tuxtla Gutiérrez (ITTG Campus I)', 'destino' => 'Chiapa de Corzo',
                'salida' => Carbon::parse("$fechaBase 18:30:00"),
                'llegada' => Carbon::parse("$fechaBase 19:00:00"),
            ],
            // 6. Comitán - Mañana
            [
                'conductor' => 1,
                'marca' => 'Chevrolet', 'modelo' => 'Spark', 'color' => 'Verde Larva', 'placas' => 'DSY-912-C',
                'asientos_disponibles' => 3,
                'origen' => 'Tuxtla Gutiérrez (Terán)', 'destino' => 'Comitán de Domínguez',
                'salida' => Carbon::parse("$fechaBase 06:30:00"),
                'llegada' => Carbon::parse("$fechaBase 09:00:00"),
            ],
            // 7. Comitán - Tarde (Mismo destino, diferente hora)
            [
                'conductor' => 1,
                'marca' => 'SEAT', 'modelo' => 'Ibiza', 'color' => 'Rojo Deseo', 'placas' => 'DNW-551-A',
                'asientos_disponibles' => 3,
                'origen' => 'Tuxtla Gutiérrez (ITTG Campus I)', 'destino' => 'Comitán de Domínguez',
                'salida' => Carbon::parse("$fechaBase 15:00:00"),
                'llegada' => Carbon::parse("$fechaBase 17:30:00"),
            ],
            // 8. Tapachula - Viaje largo de fin de semana
            [
                'conductor' => 2,
                'marca' => 'Volkswagen', 'modelo' => 'Vento', 'color' => 'Negro', 'placas' => 'DNY-102-B',
                'asientos_disponibles' => 4,
                'origen' => 'Tuxtla Gutiérrez (La Pochota)', 'destino' => 'Tapachula (Centro)',
                'salida' => Carbon::parse("$fechaBase 05:00:00"),
                'llegada' => Carbon::parse("$fechaBase 11:00:00"),
            ],
            // 9. Villaflores
            [
                'conductor' => 3,
                'marca' => 'Nissan', 'modelo' => 'March', 'color' => 'Azul', 'placas' => 'DPM-881-B',
                'asientos_disponibles' => 2,
                'origen' => 'Tuxtla Gutiérrez (Centro)', 'destino' => 'Villaflores',
                'salida' => Carbon::parse("$fechaBase 13:00:00"),
                'llegada' => Carbon::parse("$fechaBase 14:45:00"),
            ],
            // 10. Palenque - Viaje largo
            [
                'conductor' => 2,
                'marca' => 'Volkswagen', 'modelo' => 'Vento', 'color' => 'Blanco', 'placas' => 'DRK-234-A',
                'asientos_disponibles' => 4,
                'origen' => 'Tuxtla Gutiérrez (ITTG Campus I)', 'destino' => 'Palenque',
                'salida' => Carbon::parse("$fechaBase 04:30:00"),
                'llegada' => Carbon::parse("$fechaBase 10:30:00"),
            ],
        ];

        foreach ($viajes as $indice => $viaje) {
            // Usamos una combinación lógica para evitar duplicados si corres el seeder varias veces
            DB::table('viajes')->updateOrInsert(
                [
                    'conductor' => $viaje['conductor'],
                    'salida' => $viaje['salida'],
                ],
                [
                    'marca' => $viaje['marca'],
                    'modelo' => $viaje['modelo'],
                    'color' => $viaje['color'],
                    'placas' => $viaje['placas'],
                    'asientos_disponibles' => $viaje['asientos_disponibles'],
                    'origen' => $viaje['origen'],
                    'destino' => $viaje['destino'],
                    'llegada' => $viaje['llegada'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
        }
    }
}