import Navbar from "./Navbar";
import Sidebar from "./Sidebar";

const Caja = () => {
  return (
    <div>
      <Navbar />
      <div className="flex">
        <Sidebar />
        <div className="m-auto w-full mt-10 p-6 max-w-screen-md">
          <h1 className="text-xl font-semibold mb-2">Efectivo Neto en Caja:</h1>
          <h1 className="text-lg mb-6">Moneda:</h1>

          <form className="space-y-6">
            {/* Ingresos */}
            <div>
              <h2 className="text-lg font-bold border-b pb-2 mb-4">Ingresos</h2>
              <div className="flex flex-col md:flex-row gap-4">
                <input
                  name="ingreso_monto"
                  placeholder="Ingrese Monto"
                  type="number"
                  className="h-12 px-4 border rounded-md w-full"
                />
                <button
                  type="button"
                  className="bg-blue-500 text-white font-bold py-2 px-4 rounded-md h-12"
                >
                  Agregar dinero en Caja
                </button>
              </div>
            </div>

            {/* Egresos */}
            <div>
              <h2 className="text-lg font-bold border-b pb-2 mb-4">Egresos</h2>
              <div className="flex flex-col md:flex-row gap-4">
                <input
                  name="egreso_motivo"
                  placeholder="Motivo del Retiro"
                  type="text"
                  className="h-12 px-4 border rounded-md w-full"
                />
                <input
                  name="egreso_monto"
                  placeholder="Ingrese Monto"
                  type="number"
                  className="h-12 px-4 border rounded-md w-full"
                />
                <button
                  type="button"
                  className="bg-blue-500 text-white font-bold py-2 px-4 rounded-md h-12"
                >
                  Retirar dinero en Caja
                </button>
              </div>
            </div>

            {/* Filtros */}
            <div>
              <h2 className="text-lg font-bold border-b pb-2 mb-4">
                Movimientos de Caja - Filtros
              </h2>

              <div className="flex flex-col md:flex-row gap-4">
                <input
                  name="fecha_inicio"
                  type="date"
                  className="h-12 px-4 border rounded-md w-full"
                />
                <button
                  type="button"
                  className="bg-blue-500 text-white font-bold py-2 px-4 rounded-md h-12"
                >
                  Ingresos Caja
                </button>
              </div>

              <div className="flex flex-col md:flex-row gap-4 mt-4">
                <input
                  name="fecha_final"
                  type="date"
                  className="h-12 px-4 border rounded-md w-full"
                />
                <button
                  type="button"
                  className="bg-blue-500 text-white font-bold py-2 px-4 rounded-md h-12"
                >
                  Egresos Caja
                </button>
              </div>

              <div className="flex justify-end mt-6">
                <button
                  type="button"
                  className="bg-blue-500 text-white font-bold py-2 px-4 rounded-md w-48 h-12"
                >
                  Movimientos Caja
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  );
};

export default Caja;
