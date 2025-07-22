import { useEffect, useState, forwardRef, useImperativeHandle } from "react";
import axios from "../config/axios-instance.jsx";

const ResumenParqueadero = forwardRef((props, ref) => {
  const [resumen, setResumen] = useState({
    total: 0,
    ocupados: 0,
    disponibles: 0,
  });

  const fetchResumen = async () => {
    try {
      const response = await axios.get("/parqueadero/resumen");
      setResumen(response.data);
    } catch (error) {
      console.error("Error al obtener resumen del parqueadero", error);
    }
  };

  useEffect(() => {
    fetchResumen(); // inicial
    const interval = setInterval(fetchResumen, 15000); // cada 15s

    return () => clearInterval(interval);
  }, []);

  useImperativeHandle(ref, () => ({
    refetch: fetchResumen,
  }));

  return (
    <div className="rounded-xl shadow p-4 bg-white mb-4">
      <h2 className="text-lg font-bold mb-2">Resumen del Parqueadero</h2>
      <p>
        <strong>Total:</strong> {resumen.total}
      </p>
      <p>
        <strong>Ocupados:</strong> {resumen.ocupados}
      </p>
      <p>
        <strong>Disponibles:</strong> {resumen.disponibles}
      </p>
    </div>
  );
});

ResumenParqueadero.displayName = "ResumenParqueadero";

export default ResumenParqueadero;
