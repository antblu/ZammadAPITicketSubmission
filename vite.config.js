// vite.config.js
import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  plugins: [vue()],

  // We want Nextcloud to load js/main.js via Util::addScript($app, 'main')
  build: {
    outDir: 'js',          // <-- puts the build in apps/<id>/js/
    emptyOutDir: true,     // cleans the js/ folder before building
    assetsDir: '',         // keep assets flat inside js/
    rollupOptions: {
      input: 'src/main.js',
      output: {
        entryFileNames: 'main.js',     // <-- js/main.js
        chunkFileNames: '[name].js',
        assetFileNames: '[name][extname]', // css -> js/style.css unless you also addStyle()
      }
    }
  }
})
