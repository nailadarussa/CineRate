import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/sass/app.scss', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    // TAMBAHKAN BAGIAN INI:
    css: {
        preprocessorOptions: {
            scss: {
                // Opsi ini akan menyembunyikan warning spesifik tersebut
                silenceDeprecations: ['import', 'global-builtin', 'color-functions'],
                
                // Jika masih muncul, bisa coba tambahkan baris ini juga:
                quietDeps: true, 
            },
        },
    },
});