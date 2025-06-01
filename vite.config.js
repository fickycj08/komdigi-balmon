import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css'],
      refresh: true,
    }),
  ],
  server: {
    host: '127.0.0.1', // Bisa juga 'localhost'
    port: 5173,
    hmr: {
  host: 'localhost',
},

  },
});
