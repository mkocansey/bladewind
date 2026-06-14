import { defineConfig } from 'vite'
import tailwindcss from '@tailwindcss/vite'
import { resolve } from 'path'

export default defineConfig({
    plugins: [
        tailwindcss(),
    ],

    build: {
        // Output compiled assets alongside the compiled CSS bundle
        outDir: 'public',
        emptyOutDir: false,

        rollupOptions: {
            input: {
                // Single compiled bundle for users who install the full package.
                // Per-package CSS is compiled separately via the package:build scripts.
                'css/bladewind-ui.min': resolve(__dirname, 'tailwind.css'),
            },
            output: {
                // CSS files are emitted directly; no JS chunk needed for the CSS entry.
                assetFileNames: (assetInfo) => {
                    if (assetInfo.name?.endsWith('.css')) {
                        return 'css/bladewind-ui.min[extname]'
                    }
                    return 'assets/[name]-[hash][extname]'
                },
                // Prevent Vite from emitting a JS file for the CSS-only entry.
                entryFileNames: 'assets/[name]-[hash].js',
                chunkFileNames: 'assets/[name]-[hash].js',
            },
        },
    },
})
