import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/filament/fuse-theme.css','resources/css/filament/fuse-theme.css'],
            refresh: true,
        }),
    ],
});
