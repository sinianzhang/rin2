import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';
import fs from 'fs';

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
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
        // HTTPS https://localhost:8443
        https: {
            key: fs.readFileSync('/home/zhangsinian/certs/localhost+2-key.pem'),
            cert: fs.readFileSync('/home/zhangsinian/certs/localhost+2.pem'),
        },
        host: 'localhost',
    },
});
