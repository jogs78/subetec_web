<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UsuarioSeeder extends Seeder // <-- CORREGIDO: Debe decir UsuarioSeeder, no ViajeSeeder
{
    public function run(): void
    {
        $usuarios = [
            ['id' => 1, 'nombre' => 'Jorge Octavio', 'correo' => 'jorge'],
            ['id' => 2, 'nombre' => 'Fulanito Detal', 'correo' => 'fulanito'],
            ['id' => 3, 'nombre' => 'Carlos Eduardo', 'correo' => 'carlos'],
            ['id' => 4, 'nombre' => 'Ana Valeria', 'correo' => 'ana'],
            ['id' => 5, 'nombre' => 'María Fernanda', 'correo' => 'maria'],
            ['id' => 6, 'nombre' => 'Alejandro Ruiz', 'correo' => 'alejandro'],
        ];

        foreach ($usuarios as $usr) {
            DB::table('usuarios')->updateOrInsert(
                ['id' => $usr['id']],
                [
                    'nombre' => $usr['nombre'],
                    'correo' => $usr['correo'],
                    'microsoft_id' => 'ms-mock-oauth2-' . (10000 + $usr['id']),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
        }
    }
}