import Navbar from "./Navbar";
import Sidebar from "./Sidebar";

const Reportes = () => {
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
                className="border p-2 rounded w-full"
              />
            </div>
            <button className="bg-blue-500 text-white py-2 px-6 rounded h-11 hover:bg-blue-600 transition">
              Mostrar
            </button>
          </div>

          {/* Opciones de reporte */}
          <div className="flex justify-center">
            <div className="flex flex-col space-y-4 w-full md:w-1/3">
              {[
                "Listar Tickets",
                "Salidas de Vehiculos",
                "Vehiculos Estacionados",
                "Pagos de Tickets",
              ].map((text, idx) => (
                <button
                  key={idx}
                  className="bg-blue-500 text-white py-3 px-6 rounded hover:bg-blue-600 transition"
                >
                  {text}
                </button>
              ))}
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Reportes;
