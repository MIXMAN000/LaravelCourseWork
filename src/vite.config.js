import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';


export default defineConfig({
    plugins: [
        laravel({
            input: [
              'resources/css/app.css',
              'resources/js/app.js',
              'resources/js/cardSlider.js',
              'resources/js/index.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        // 1. Разрешаем подключения с любого сетевого интерфейса
        host: '0.0.0.0',
        // 2. Явно указываем порт (хотя 5173 используется по умолчанию)
        port: 5173,
        // 3. Настраиваем Hot Module Replacement (HMR) для WebSocket-соединений
        hmr: {
            host: 'localhost',
        },
        // 4. Решаем проблему с отслеживанием изменений файлов
        watch: {
            usePolling: true,
        },
    },

});
