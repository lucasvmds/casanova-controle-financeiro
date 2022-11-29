import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { svelte } from "@sveltejs/vite-plugin-svelte";
import SveltePreprocess from "svelte-preprocess";

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js'],
            refresh: [
                'resources/svelte/**',
            ],
        }),
        svelte({
            preprocess: [
                SveltePreprocess({
                    typescript: true,
                }),
            ],
            prebundleSvelteLibraries: true,
        }),
    ],
});
