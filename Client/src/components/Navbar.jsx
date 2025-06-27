import { useEffect, useState } from "react";
import { Link } from "react-router-dom";
import { RiMore2Line } from "react-icons/ri";
import useAuth from "../hooks/useAuth";

const Navbar = () => {
  const { user } = useAuth();
  const [currentTime, setCurrentTime] = useState("");
  const [currentDate, setCurrentDate] = useState("");

  useEffect(() => {
    const updateDateTime = () => {
      const now = new Date();

      // Fecha en formato largo, ej: martes, 18 de junio de 2025
      const dateString = now.toLocaleDateString("es-CO", {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
      });

      // Hora en formato 12h con AM/PM
      const timeString = now.toLocaleTimeString("es-CO", {
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
        hour12: true, // Puedes cambiar a false para 24h
      });

      setCurrentDate(dateString);
      setCurrentTime(timeString);
    };

    updateDateTime();
    const interval = setInterval(updateDateTime, 1000);

    return () => clearInterval(interval);
  }, []);

  return (
    <nav className="h-[7vh] md:h-[10vh] border-b border-secondary-100 px-6 flex items-center justify-between bg-blue-500 text-white">
      <ul className="inline-flex items-center gap-4 text-xl">
        <li>
          <Link
            to="/home"
            title="Ir a la página principal"
            className="hover:underline"
          >
            Home
          </Link>
        </li>
        <li className="hidden md:inline-block text-white/90">
          📅 {currentDate}
        </li>
        <li className="text-white/90">🕒 {currentTime}</li>
      </ul>
      <div className="flex items-center gap-4 text-xl">
        {user && <span className="text-xl">Hola, {user.name}</span>}
        <Link
          to="/admin"
          title="Panel de administración"
          className="hover:underline"
        >
          Admin
        </Link>
        <RiMore2Line className="h-8 w-8 cursor-pointer" title="Más opciones" />
      </div>
    </nav>
  );
};

export default Navbar;
