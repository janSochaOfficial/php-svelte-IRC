import { defineConfig } from 'vite'
import { svelte } from '@sveltejs/vite-plugin-svelte'
import appConfig from "./src/appconfig.json" 

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [svelte()],
  base: appConfig.baseDir,
  build: {
    outDir: appConfig.outputDir,
  }
})
