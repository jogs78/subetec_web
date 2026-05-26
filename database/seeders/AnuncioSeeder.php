<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnuncioSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('anuncios')->delete();

        DB::table('anuncios')->insert([
            [
                'imagen' => 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=500&auto=format&fit=crop&q=60',
                'titulo' => 'Tacos de Cochito "El Profe"',
                'descripcion' => 'Los tradicionales de Chiapa de Corzo con doble copia, cebolla morada y salsa secreta.',
                'oferta' => '32% OFF',
                'precio' => 12.00,
                'categoria' => 'Comida',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'imagen' => 'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?w=500&auto=format&fit=crop&q=60',
                'titulo' => 'Hospedaje Universitario Chiapa',
                'descripcion' => 'Habitación amueblada, baño propio, internet de alta velocidad. A 5 minutos del Tec.',
                'oferta' => '15% DTO',
                'precio' => 350.00,
                'categoria' => 'Hospedaje',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'imagen' => 'https://images.unsplash.com/photo-1513104890138-7c749659a591?w=500&auto=format&fit=crop&q=60',
                'titulo' => 'Pizzería La Squadra',
                'descripcion' => 'Pizza grande de pepperoni o cuatro quesos. Ideal para tus reuniones de estudio.',
                'oferta' => 'Promo Real',
                'precio' => 87.30,
                'categoria' => 'Comida',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'imagen' => 'https://images.unsplash.com/photo-1586075010923-2dd4570fb338?w=500&auto=format&fit=crop&q=60',
                'titulo' => 'Copias y Papelería SubeTec',
                'descripcion' => 'Impresiones láser blanco/negro y color, engargolados y material escolar con descuento.',
                'oferta' => 'Estudiantes',
                'precio' => 0.50,
                'categoria' => 'Copias',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'imagen' => 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?w=500&auto=format&fit=crop&q=60',
                'titulo' => 'Ensaladas Frescas "TecFit"',
                'descripcion' => 'Arma tu ensalada con proteína a elección (pollo, atún o tofu) y aderezo artesanal.',
                'oferta' => 'Saludable',
                'precio' => 45.00,
                'categoria' => 'Comida',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'imagen' => 'https://images.unsplash.com/photo-1551024709-8f23befc6f87?w=500&auto=format&fit=crop&q=60',
                'titulo' => 'Donas y Café "La Pausa"',
                'descripcion' => 'Combo de café americano grande de la región y una dona glaseada para iniciar el día.',
                'oferta' => 'Desayuno',
                'precio' => 25.00,
                'categoria' => 'Comida',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'imagen' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=500&auto=format&fit=crop&q=60',
                'titulo' => 'Asesorías de Programación Web',
                'descripcion' => 'Regularización y apoyo en proyectos de Laravel, Vue.js y bases de datos relacionales.',
                'oferta' => '1ra Gratis',
                'precio' => 60.00,
                'categoria' => 'Copias',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'imagen' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=500&auto=format&fit=crop&q=60',
                'titulo' => 'Venta de Libros de Ingeniería',
                'descripcion' => 'Libros semi-nuevos de cálculo, estructuras de datos y redes a mitad de precio.',
                'oferta' => 'Remate',
                'precio' => 150.00,
                'categoria' => 'Copias',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'imagen' => 'https://images.unsplash.com/photo-1621605815971-fbc98d665033?w=500&auto=format&fit=crop&q=60',
                'titulo' => 'Servicio Técnico "TecFix"',
                'descripcion' => 'Mantenimiento preventivo, formateo, instalación de software y optimización de laptops.',
                'oferta' => 'Garantizado',
                'precio' => 200.00,
                'categoria' => 'Copias',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'imagen' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=500&auto=format&fit=crop&q=60',
                'titulo' => 'Cafetería Central - Menú Estudiantil',
                'descripcion' => 'Comida corrida completa: sopa, plato fuerte del día, agua de sabor y postre.',
                'oferta' => 'Menú Almuerzo',
                'precio' => 50.00,
                'categoria' => 'Comida',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}