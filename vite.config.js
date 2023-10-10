import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { resolve } from "path";
import tailwindcss from "tailwindcss";


export default defineConfig({
    plugins: [
        laravel({
            input: [        
            "resources/js/app.js",
        ],
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
    ],
    css: {
        postcss: {
          plugins: [
            tailwindcss({
              config: "./kingscms.tailwind.config.js",
            }),
          ],
        },
      },
    resolve: {
        alias: {
          "@": resolve(__dirname, "./resources/js"),
          "craftable-pro": resolve(
            __dirname,
            "./resources/kingscms/resources/js"
          ),
        },
      },
});
