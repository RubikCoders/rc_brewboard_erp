import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',                                
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
        cssCodeSplit: true,        
        target: 'es2015',        
        minify: 'esbuild',
        esbuild: {            
            drop: ['console'],
        }
    },
    server: {
        hmr: {
            host: 'localhost',
        },
        watch: {
            usePolling: true,
        }
    },
    optimizeDeps: {
        include: ['axios']
    }
});
