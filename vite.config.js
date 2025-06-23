import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig(({ mode }) => {
    const env = loadEnv(mode, process.cwd());
    return {
        server: {
            host: '0.0.0.0', // allows external access
            port: 5173,
            cors: true,
            hmr: {
                host: env.VITE_DEV_SERVER_HOST,
                protocol: 'http',
            },
        },
        plugins: [
            laravel({
                input: [
                    'resources/sass/app.scss',
                    'resources/js/app.js',
                ],
                refresh: true,
            }),
        ],
    };
});
