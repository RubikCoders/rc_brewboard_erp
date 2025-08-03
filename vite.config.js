import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/filament/admin/theme.css',
                'resources/css/landing.css',
                'resources/js/landing.js'
            ],
            refresh: true,
        }),        
        tailwindcss(),
    ],
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    // Separate vendor code for better caching
                    vendor: ['axios'],
                    // Landing page specific chunks
                    landing: ['./resources/js/landing.js']
                }
            }
        },
        // Enable CSS code splitting
        cssCodeSplit: true,
        // Optimize for modern browsers
        target: 'es2015',
        // Minify for production
        minify: 'terser',
        terserOptions: {
            compress: {
                drop_console: true, // Remove console.logs in production
            }
        }
    },
    server: {
        hmr: {
            host: 'localhost',
        },
        watch: {
            usePolling: true, // Better for Docker/VM environments
        }
    },
    optimizeDeps: {
        include: ['axios']
    }
});
