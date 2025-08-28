// vite.config.js
import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue2'  // ⬅️ Vue 2 plugin

export default defineConfig({
  plugins: [vue()],
  build: {
    outDir: 'js',           // Nextcloud expects apps/<id>/js/
    emptyOutDir: true,
    assetsDir: '',
    rollupOptions: {
      input: 'src/main.js',
      output: {
        entryFileNames: 'main.js',
        chunkFileNames: '[name].js',
        assetFileNames: '[name][extname]'
      }
    }
  }
})
