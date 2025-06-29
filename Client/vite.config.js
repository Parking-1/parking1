import { defineConfig } from "vite";
import react from "@vitejs/plugin-react";

export default defineConfig({
  plugins: [react()],
  server: {
    host: "parking.local", // 🔧 <- clave
    port: 5173,
    cors: true,
    proxy: {
      "/api": {
        target: "http://parking.local:8080",
        changeOrigin: true,
        secure: false,
      },
    },
  },
});
