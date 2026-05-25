<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
// Insertamos el usuario con ID = 1 para que coincida perfectamente con el prototipo de Flutter
        DB::table('usuarios')->updateOrInsert(
            ['id' => 1], // Si ya existe el ID 1, lo actualiza; si no, lo crea.
            [
                'nombre' => 'Jorge Octavio',
                'correo' => 'jorge.octavio@tuxtla.tecnm.mx',
                'microsoft_id' => 'ms-mock-oauth2-12345',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        DB::table('usuarios')->updateOrInsert(
            ['id' => 2], // Si ya existe el ID 2, lo actualiza; si no, lo crea.
            [
                'nombre' => 'Fulanito',
                'correo' => 'fulano@tuxtla.tecnm.mx',
                'microsoft_id' => 'ms-mock-oauth2-12345',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );        
    }
}
