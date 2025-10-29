import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import rtlcss from 'rtlcss';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'public/assets/dashboard/css/adminlte-ltr.min.css',
                'public/assets/dashboard/css/adminlte-rtl.min.css'
            ],
            refresh: true,
        }),
        {
            name: 'rtlcss',
            transform: (code, id) => {
                if (id.includes('adminlte-rtl.min.css')) {
                    return rtlcss.process(code);
                }
            }
        }
    ],
});
