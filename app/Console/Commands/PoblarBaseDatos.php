<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class PoblarBaseDatos extends Command
{
    /**
     * El nombre y la firma del comando en la terminal.
     */
    protected $signature = 'poblar {tipo : El tipo de datos a poblar (usuarios o viajes)}';

    /**
     * La descripción del comando.
     */
    protected $description = 'Ejecuta seeders específicos (usuarios o viajes) de forma independiente';

    /**
     * Ejecuta la lógica del comando.
     */
    public function handle()
    {
        $tipo = strtolower($this->argument('tipo'));

        switch ($tipo) {
            case 'usuarios':
                $this->info('Iniciando el poblado de la tabla: usuarios...');
                
                Artisan::call('db:seed', [
                    '--class' => 'UsuarioSeeder'
                ]);
                
                $this->info(Artisan::output());
                $this->info('¡Tabla de usuarios poblada con éxito!'); // <-- CORREGIDO: Usamos info en lugar de success
                break;

            case 'viajes':
                $this->info('Iniciando el poblado de la tabla: viajes...');
                
                Artisan::call('db:seed', [
                    '--class' => 'ViajeSeeder'
                ]);
                
                $this->info(Artisan::output());
                $this->info('¡Tabla de viajes poblada con éxito con las rutas de Chiapas!'); // <-- CORREGIDO: Usamos info en lugar de success
                break;

            case 'anuncios':
                $this->info('Iniciando el poblado de la tabla: anuncios...');
                
                Artisan::call('db:seed', [
                    '--class' => 'AnuncioSeeder'
                ]);
                
                $this->info(Artisan::output());
                $this->info('¡Tabla de anuncios poblada con éxito!'); // <-- CORREGIDO: Usamos info en lugar de success
                break;

            default:
                $this->error("El argumento '$tipo' no es válido.");
                $this->line("Por favor usa: 'php artisan poblar usuarios' o 'php artisan poblar viajes'");
                break;
        }

        return Command::SUCCESS;
    }
}