// src/config/axios-instance.js
import axios from "axios";

const axiosInstance = axios.create({
  baseURL: "http://parking.local:8080/api",
  withCredentials: true, // Incluye cookies (para JWT con HttpOnly)
});

export default axiosInstance;
