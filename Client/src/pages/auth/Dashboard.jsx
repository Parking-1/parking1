import { useEffect, useState } from "react";
import axios from "../api/axios"; // ajusta esta ruta según tu estructura
import ConfiguracionEmpresa from "./ConfiguracionEmpresa";

const Dashboard = () => {
  const [user, setUser] = useState(null);

  useEffect(() => {
    const fetchUser = async () => {
      try {
        const response = await axios.get("/api/user/me");
        setUser(response.data);
      } catch (error) {
        console.error("Error al obtener el usuario", error);
      }
    };

    fetchUser();
  }, []);

  return (
    <div>
      <h1>Bienvenido al sistema</h1>

      {/* Mostrar solo si el usuario es administrador */}
      {user && user.roles?.includes("Administrador") && (
        <ConfiguracionEmpresa />
      )}
    </div>
  );
};

export default Dashboard;
