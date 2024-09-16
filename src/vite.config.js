import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0',  // Listen on all network interfaces
        port: 5173,        // Use the port you expose in your Docker container
        strictPort: true,  // Makes Vite fail if the port is already in use
        hmr: {
            host: 'localhost',  // Set to your local machine's hostname or IP address accessible from the browser
            port: 5173,         // Ensure this is the same port you forward in Docker and accessible externally
        }
    }
});