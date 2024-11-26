import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';
import Components from 'unplugin-vue-components/vite';
import { PrimeVueResolver } from '@primevue/auto-import-resolver';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.ts',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        Components({
            resolvers: [
              PrimeVueResolver()
            ]
        }),
    ],
    resolve: {
        alias: {
            "@shared": path.resolve(__dirname, "./resources/js/shared"),
            "@features": path.resolve(__dirname, "./resources/js/features"),
        },
    },
});
