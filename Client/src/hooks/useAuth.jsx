import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import axios from "../config/axios-instance"; // Asegúrate de importar el correcto
import { toast } from "react-toastify";

const useAuth = () => {
  const [user, setUser] = useState(null);
  const [authLoading, setAuthLoading] = useState(true);
  const navigate = useNavigate();

  useEffect(() => {
    const fetchUser = async () => {
      try {
        const response = await axios.get("/user/me");
        setUser(response.data.user);
      } catch (error) {
        console.error("Error al obtener el usuario:", error);
        setUser(null);
      } finally {
        setAuthLoading(false);
      }
    };

    fetchUser();
  }, []);

  const logout = async () => {
    try {
      await axios.post("/user/logout");
      toast.success("Sesión cerrada correctamente", { theme: "dark" });
    } catch (e) {
      console.error("Error cerrando sesión:", e);
      toast.error("Error al cerrar sesión", { theme: "dark" });
    } finally {
      setUser(null);
      navigate("/login"); // Redirigir al login
    }
  };

  return {
    user,
    authLoading,
    isAuthenticated: !!user,
    logout,
  };
};

export default useAuth;
