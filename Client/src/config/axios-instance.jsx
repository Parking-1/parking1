// src/config/axios-instance.js
import axios from "axios";
import { toast } from "react-toastify";

const axiosInstance = axios.create({
  baseURL: "/api",
  withCredentials: true, // Incluye cookies (para JWT con HttpOnly)
});

// Interceptor de respuesta
axiosInstance.interceptors.response.use(
  (response) => response,
  (error) => {
    if (
      error.response &&
      error.response.data &&
      error.response.data.error === "Token no encontrado"
    ) {
      toast.error(
        "❌ Tu sesión ha expirado. Por favor, inicia sesión nuevamente."
      );
      setTimeout(() => {
        window.location.href = "/login"; // o usa `navigate()` con React Router
      }, 2000);
    }
    return Promise.reject(error);
  }
);

export default axiosInstance;
