import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    build: {
        rollupOptions: {
            output: {
                assetFileNames: (assetInfo) => {
                    if (assetInfo.name.endsWith('.css')) {
                        return 'assets/[name].[ext]'; // CSS files in 'css' folder
                    }
                    if (assetInfo.name.endsWith('.js')) {
                        return 'assets/[name].[ext]'; // JS files in 'js' folder
                    }

                    return 'assets/[name]-[hash].[ext]'; // Other assets (fonts, etc.)
                },
            },
        },
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
