import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue'; // <--- Se mantiene tu importación

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
            ],
        }),
        tailwindcss(),
        vue(), // <--- 📌 CAMBIO CRÍTICO: Aquí activamos el compilador de Vue para Vite
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
    // 📌 ADICIÓN RECOMENDADA: Ayuda a resolver las rutas de tus componentes de forma limpia
    resolve: {
        alias: {
            '@': '/resources/js',
        },
    },
});