import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";
import vue from "@vitejs/plugin-vue";
import path from "path";

process.env.NODE_ENV = 'development'; // Required for VueDevTools

export default defineConfig({
    build: {
        minify: true,
        rollupOptions: {
            output:{
                manualChunks: {     // split biggest vendors in separate chunks
                    'echarts': ['echarts'],
                    'dropzone': ['dropzone-vue3'],
                    'vue': ['vue']
                }
            }
        }
    },
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
            '@': path.resolve(__dirname, 'resources/'),
            '@vendor': path.resolve(__dirname, 'vendor/'),
            '~': path.resolve(__dirname, 'node_modules/'),
            '@modular-forms': path.resolve(__dirname, 'vendor/andreamarelli/modular-forms/src/resources/assets'),
            '@imet-core': path.resolve(__dirname, 'vendor/andreamarelli/imet-core/src/resources/assets'),
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/index.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        })
    ]
});
