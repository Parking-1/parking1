import Navbar from "./Navbar";
import Sidebar from "./Sidebar";

const Salidas = () => {
  return (
    <div>
      <Navbar />
      <div className="flex">
        <Sidebar />
        <div className="flex flex-col justify-center items-center mx-auto my-12 w-full">
          <div className="flex flex-col md:flex-row w-full max-w-5xl p-4">
            {/* Columna de búsqueda */}
            <div className="md:w-1/3 pr-4">
              <form className="flex flex-col space-y-4">
                <label htmlFor="placa">Buscar por placa</label>
                <input
                  id="placa"
                  type="text"
                  className="w-full py-2 px-4 border rounded"
                  placeholder="Ej. ABC123"
                />
                <label htmlFor="ticket">Buscar por Nro de ticket</label>
                <input
                  id="ticket"
                  type="text"
                  className="w-full py-2 px-4 border rounded"
                  placeholder="Ej. 001"
                />
              </form>
            </div>

            {/* Columna de detalles */}
            <div className="md:w-2/3 p-4 border rounded ml-0 md:ml-8 mt-6 md:mt-0 bg-gray-50">
              <div className="grid grid-cols-2 gap-4">
                <div>
                  <strong>Placa:</strong> ABC123
                </div>
                <div>
                  <strong>Hora de Salida:</strong> 10:30 AM
                </div>
                <div>
                  <strong>Hora de Entrada:</strong> 08:00 AM
                </div>
                <div>
                  <strong>Fecha de Salida:</strong> 17/06/2025
                </div>
                <div>
                  <strong>Fecha de Entrada:</strong> 17/06/2025
                </div>
                <div>
                  <strong>Cobro por Parking:</strong> $10.000
                </div>
                <div>
                  <strong>Clase de Vehiculo:</strong> Auto
                </div>
                <div>
                  <strong>Cobro por Lavado:</strong> $5.000
                </div>
                <div>
                  <strong>Tiempo Transcurrido:</strong> 2h 30min
                </div>
                <div className="col-span-2">
                  <div className="flex items-center space-x-4">
                    <input id="servicio" type="checkbox" />
                    <label htmlFor="servicio">Servicio adicional</label>
                    <input id="no-servicio" type="checkbox" />
                    <label htmlFor="no-servicio">Sin servicio adicional</label>
                  </div>
                </div>
              </div>

              <div className="flex justify-center mt-6">
                <button className="bg-green-500 text-white font-bold py-2 px-6 rounded hover:bg-green-600 transition">
                  Confirmar Salida y Pagar
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Salidas;
