import { useState } from "react";
import Navbar from "./Navbar";
import Sidebar from "./Sidebar";

const Reportes = () => {
  const [fechaInicio, setFechaInicio] = useState("");
  const [fechaFinal, setFechaFinal] = useState("");
  const [tipoReporte, setTipoReporte] = useState("");
  const [datos, setDatos] = useState([]);

  const opciones = [
    { label: "Listar Tickets", tipo: "tickets" },
    { label: "Salidas de Vehiculos", tipo: "salidas" },
    { label: "Vehiculos Estacionados", tipo: "estacionados" },
    { label: "Pagos de Tickets", tipo: "pagos" },
  ];

  const handleReporte = async (tipo) => {
    if (!fechaInicio || !fechaFinal) {
      alert("Por favor selecciona ambas fechas.");
      return;
    }

    setTipoReporte(tipo);

    try {
      const res = await fetch("/api/reportes", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        credentials: "include",
        body: JSON.stringify({
          tipo,
          fecha_inicio: fechaInicio,
          fecha_final: fechaFinal,
        }),
      });

      const result = await res.json();
      if (res.ok) {
        setDatos(result.data);
      } else {
        alert(result.error || "Error al generar reporte");
      }
    } catch (err) {
      console.error(err);
      alert("Error al conectar con el servidor.");
    }
  };

  return (
    <div>
      <Navbar />
      <div className="flex">
        <Sidebar />
        <div className="flex flex-col w-full p-6">
          {/* Filtros por fecha */}
          <div className="flex flex-col md:flex-row justify-center space-y-4 md:space-y-0 md:space-x-4 mb-8 items-end mt-12">
            <div className="flex flex-col w-full md:w-1/3">
              <label
                htmlFor="fechaInicio"
                className="mb-1 text-center font-semibold"
              >
                Fecha de Inicio
              </label>
              <input
                id="fechaInicio"
                type="date"
                value={fechaInicio}
                onChange={(e) => setFechaInicio(e.target.value)}
                className="border p-2 rounded w-full"
              />
            </div>
            <div className="flex flex-col w-full md:w-1/3">
              <label
                htmlFor="fechaFinal"
                className="mb-1 text-center font-semibold"
              >
                Fecha Final
              </label>
              <input
                id="fechaFinal"
                type="date"
                value={fechaFinal}
                onChange={(e) => setFechaFinal(e.target.value)}
                className="border p-2 rounded w-full"
              />
            </div>
          </div>

          {/* Opciones de reporte */}
          <div className="flex justify-center">
            <div className="flex flex-col space-y-4 w-full md:w-1/3">
              {opciones.map(({ label, tipo }) => (
                <button
                  key={tipo}
                  onClick={() => handleReporte(tipo)}
                  className="bg-blue-500 text-white py-3 px-6 rounded hover:bg-blue-600 transition"
                >
                  {label}
                </button>
              ))}
            </div>
          </div>

          {/* Resultados */}
          {datos.length > 0 && (
            <div className="mt-10">
              <h2 className="text-xl font-semibold mb-4 text-center capitalize">
                Resultados de {tipoReporte.replace(/_/g, " ")} ({datos.length})
              </h2>
              <pre className="bg-gray-100 p-4 rounded overflow-auto max-h-[400px] text-sm">
                {JSON.stringify(datos, null, 2)}
              </pre>
            </div>
          )}
        </div>
      </div>
    </div>
  );
};

export default Reportes;
