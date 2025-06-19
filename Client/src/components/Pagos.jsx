import Navbar from "./Navbar";
import Sidebar from "./Sidebar";

const Pagos = () => {
  return (
    <div>
      <Navbar />
      <div className="flex">
        <Sidebar />
        <div className="flex flex-col justify-center items-center mx-auto my-10 w-full max-w-4xl">
          <div className="bg-white shadow-md p-6 rounded-lg w-full">
            <form className="space-y-4">
              {/* Buscar */}
              <div className="flex flex-wrap items-end gap-4">
                <button
                  type="submit"
                  className="bg-green-500 text-white font-bold py-2 px-6 rounded-md"
                >
                  Buscar
                </button>
                <div className="flex flex-col flex-1">
                  <label htmlFor="codigoPlan" className="font-medium mb-1">
                    Código del plan
                  </label>
                  <input
                    id="codigoPlan"
                    name="codigoPlan"
                    type="text"
                    className="w-full h-12 px-4 py-2 border rounded-lg"
                    placeholder="Ej: 001234"
                  />
                </div>
              </div>

              {/* Datos del abonado */}
              <div>
                <label htmlFor="nombres" className="block font-medium mb-1">
                  Nombres y Apellidos
                </label>
                <input
                  id="nombres"
                  name="nombres"
                  type="text"
                  className="w-full h-12 px-4 py-2 border rounded-lg"
                />
              </div>

              <div>
                <label htmlFor="documento" className="block font-medium mb-1">
                  Documento
                </label>
                <input
                  id="documento"
                  name="documento"
                  type="text"
                  className="w-full h-12 px-4 py-2 border rounded-lg"
                />
              </div>

              <div>
                <label htmlFor="placa" className="block font-medium mb-1">
                  Placa del Vehículo
                </label>
                <input
                  id="placa"
                  name="placa"
                  type="text"
                  className="w-full h-12 px-4 py-2 border rounded-lg uppercase"
                />
              </div>

              <div>
                <label htmlFor="fecha" className="block font-medium mb-1">
                  Fecha del Pago
                </label>
                <input
                  id="fecha"
                  name="fecha"
                  type="date"
                  className="w-full h-12 px-4 py-2 border rounded-lg"
                />
              </div>

              <div>
                <label htmlFor="vencimiento" className="block font-medium mb-1">
                  Fecha de Vencimiento del Plan
                </label>
                <input
                  id="vencimiento"
                  name="vencimiento"
                  type="date"
                  className="w-full h-12 px-4 py-2 border rounded-lg"
                />
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Pagos;
