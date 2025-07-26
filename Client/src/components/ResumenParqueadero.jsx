import { useEffect, useState, forwardRef, useImperativeHandle } from "react";
import axios from "../config/axios-instance.jsx";

const ResumenParqueadero = forwardRef((props, ref) => {
  const [resumen, setResumen] = useState({
    total: 0,
    ocupados: 0,
    disponibles: 0,
    abonados: 0,
  });

  const fetchResumen = async () => {
    try {
      const response = await axios.get("/configuracion/resumen", {
        withCredentials: true,
      });
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

  const handleLiberarEspacio = async () => {
    try {
      const response = await axios.post(
        "/configuracion/liberar-espacio",
        {},
        {
          withCredentials: true,
        }
      );
      await fetchResumen(); // Refresca datos después de liberar
    } catch (error) {
      console.error("Error al liberar espacio", error);
    }
  };

  return (
    <div className="bg-white rounded shadow p-4 mb-6 w-full max-w-4xl">
      <h2 className="text-lg font-bold mb-2">Resumen del Parqueadero</h2>
      <div className="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
        <div>
          <div className="text-xl font-bold">{resumen.espacios_totales}</div>
          <div>Total</div>
        </div>
        <div>
          <div className="text-xl font-bold">{resumen.ocupados}</div>
          <div>Ocupados</div>
        </div>
        <div>
          <div className="text-xl font-bold">{resumen.abonados}</div>
          <div>Abonados</div>
        </div>
        <div>
          <div className="text-xl font-bold">
            {resumen.espacios_disponibles}
          </div>
          <div>Disponibles</div>
        </div>
      </div>
      <div className="mt-4 text-center">
        <button
          onClick={handleLiberarEspacio}
          className="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded"
        >
          Liberar espacio
        </button>
      </div>
    </div>
  );
});

ResumenParqueadero.displayName = "ResumenParqueadero";

export default ResumenParqueadero;
