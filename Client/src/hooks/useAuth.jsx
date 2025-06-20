import { useEffect, useState } from "react";
import Axios from "axios";

const useAuth = () => {
  const [user, setUser] = useState(null);
  const [authLoading, setAuthLoading] = useState(true);

  useEffect(() => {
    const fetchUser = async () => {
      try {
        const response = await Axios.get("http://localhost:8000/api/user/me", {
          withCredentials: true, // ⬅️ usa la cookie automáticamente
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
    } catch (e) {
      console.error("Error cerrando sesión:", e);
    } finally {
      setUser(null);
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
