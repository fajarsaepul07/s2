import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // CSS
                'resources/assets/css/bootstrap.css',
                'resources/assets/css/app.css',
                'resources/assets/vendors/perfect-scrollbar/perfect-scrollbar.css',
                'resources/assets/vendors/bootstrap-icons/bootstrap-icons.css',

                // JS
                'resources/assets/js/bootstrap.bundle.min.js',
                'resources/assets/js/main.js',
            ],
            refresh: true,
        }),
    ],
});
