import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './resources'),
        },
    },
    server: {
        proxy: {
            '/app': 'http://localhost',
        },
    },
    base: process.env.NODE_ENV === 'production'
        ? 'https://gestionprof.fpvirtualaragon.es/'
        : '/',
});