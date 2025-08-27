// vite.config.js
import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  plugins: [vue()],
  build: {
    outDir: 'js',           // put build into apps/<id>/js/
    emptyOutDir: true,      // clean js/ before building
    assetsDir: '',          // keep assets flat inside js/
    rollupOptions: {
      input: 'src/main.js', // your actual entry
      output: {
        entryFileNames: 'main.js',        // => js/main.js
        chunkFileNames: '[name].js',
        assetFileNames: '[name][extname]'
      }
    }
  }
})
