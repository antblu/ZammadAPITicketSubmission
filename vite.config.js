// vite.config.js
import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  plugins: [vue()],
  build: {
    outDir: 'js',           // put build into apps/<id>/js/
    emptyOutDir: true,
    assetsDir: '',          // keep files flat under js/
    rollupOptions: {
      input: 'src/main.js', // your entry file
      output: {
        entryFileNames: 'main.js',        // => js/main.js
        chunkFileNames: '[name].js',
        assetFileNames: '[name][extname]' // e.g. js/style.css if CSS emitted
      }
    }
  }
})
