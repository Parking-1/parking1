import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import Axios from "axios";
import { toast } from "react-toastify";

const useAuth = () => {
  const [user, setUser] = useState(null);
  const [authLoading, setAuthLoading] = useState(true);
  const navigate = useNavigate();

  useEffect(() => {
    const fetchUser = async () => {
      try {
        const response = await Axios.get("http://localhost:8000/api/user/me", {
          withCredentials: true, // Enviar cookies automáticamente
        });
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
      await Axios.post("http://localhost:8000/api/user/logout", null, {
        withCredentials: true,
      });
      toast.success("Sesión cerrada correctamente", { theme: "dark" });
    } catch (e) {
      console.error("Error cerrando sesión:", e);
      toast.error("Error al cerrar sesión", { theme: "dark" });
    } finally {
      setUser(null);
      navigate("/"); // Redirigir al login
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
