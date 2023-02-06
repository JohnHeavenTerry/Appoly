import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/fruit.css', 'resources/js/fruit.js'],
            refresh: true,
        }),
    ],
});
