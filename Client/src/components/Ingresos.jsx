import Navbar from "./Navbar";
import Sidebar from "./Sidebar";

const Ingresos = () => {
  return (
    <div>
      <Navbar />
      <div className="flex">
        <Sidebar />
        <div className="flex flex-col items-center mx-auto mt-10 w-full max-w-xl">
          <form className="w-full p-6 bg-white rounded-lg shadow">
            <h1 className="text-xl font-semibold mb-4 text-center">
              Registrar Ingreso de Vehículo
            </h1>

            {/* Placa */}
            <label htmlFor="placa" className="block mb-2 font-medium">
              Ingrese placa o matrícula del vehículo
            </label>
            <input
              id="placa"
              name="placa"
              className="w-full h-12 px-4 py-2 rounded-lg border border-gray-300 text-xl uppercase mb-4"
              type="text"
              placeholder="Ej: ABC123"
            />

            {/* Tipo de Vehículo */}
            <label htmlFor="tipo" className="block mb-2 font-medium">
              Seleccione clase de vehículo
            </label>
            <select
              id="tipo"
              name="tipo"
              className="w-full h-12 px-4 py-2 rounded-lg border border-gray-300 mb-4"
            >
              <option value="auto">Auto</option>
              <option value="moto">Moto</option>
              <option value="camion">Camión</option>
              <option value="bus">Bus</option>
            </select>

            {/* Hora y Fecha */}
            <div className="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
              <div>
                <label htmlFor="hora" className="block mb-2 font-medium">
                  Hora
                </label>
                <input
                  id="hora"
                  name="hora"
                  type="time"
                  className="w-full h-12 px-4 py-2 rounded-lg border border-gray-300"
                />
              </div>
              <div>
                <label htmlFor="fecha" className="block mb-2 font-medium">
                  Fecha
                </label>
                <input
                  id="fecha"
                  name="fecha"
                  type="date"
                  className="w-full h-12 px-4 py-2 rounded-lg border border-gray-300"
                />
              </div>
            </div>

            {/* Botones */}
            <div className="flex flex-col items-center gap-4">
              <button
                type="submit"
                className="bg-green-500 text-white font-bold py-2 px-4 rounded-md w-full"
              >
                Ingresar
              </button>
              <button type="button" className="text-blue-500 hover:underline">
                ¿Desea borrar el ingreso?
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  );
};

export default Ingresos;
