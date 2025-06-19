import Navbar from "./Navbar";
import Sidebar from "./Sidebar";

const Abonados = () => {
  return (
    <div>
      <Navbar />
      <div className="flex flex-wrap">
        <Sidebar />
        <div className="m-auto w-full max-w-screen-lg p-4">
          <form className="space-y-6">
            <div className="grid grid-cols-4 gap-4">
              <input
                name="nombre"
                className="h-12 px-4 py-2 rounded-lg border border-gray-300 text-lg uppercase"
                type="text"
                placeholder="Nombres y Apellidos"
              />
              <input
                name="documento"
                className="h-12 px-4 py-2 rounded-lg border border-gray-300 text-lg uppercase"
                type="text"
                placeholder="Nro de Documento"
              />
              <input
                name="placa"
                className="h-12 px-4 py-2 rounded-lg border border-gray-300 text-lg uppercase"
                type="text"
                placeholder="Placa de Vehiculo"
              />
              <button
                type="button"
                className="bg-green-500 text-white font-bold rounded-md h-12"
              >
                Buscar Abonado
              </button>
            </div>

            <div className="grid grid-cols-4 gap-4">
              <input
                name="monto"
                className="h-12 px-4 py-2 rounded-lg border border-gray-300 text-lg uppercase"
                type="text"
                placeholder="Monto x Sem. o Mes."
              />
              <select
                name="duracion"
                className="h-12 px-4 py-2 rounded-lg border border-gray-300 text-lg uppercase"
              >
                <option disabled selected>
                  Duración del Plan
                </option>
                <option>15 días</option>
                <option>30 días</option>
                <option>60 días</option>
              </select>
              <select
                name="tipo_plan"
                className="h-12 px-4 py-2 rounded-lg border border-gray-300 text-lg uppercase"
              >
                <option disabled selected>
                  Tipo de Plan
                </option>
                <option>Semanal</option>
                <option>Mensual</option>
              </select>
              <button
                type="button"
                className="bg-green-500 text-white font-bold rounded-md h-12"
              >
                Calcular Plan
              </button>
            </div>

            <div className="grid grid-cols-2 gap-4">
              <input
                name="fecha_inicio"
                className="h-12 px-4 py-2 rounded-lg border border-gray-300 text-lg uppercase"
                type="date"
              />
              <input
                name="total"
                className="h-12 px-4 py-2 rounded-lg border border-gray-300 text-lg uppercase"
                type="number"
                placeholder="Total del Plan"
              />
            </div>

            <div className="overflow-x-auto">
              <table className="w-full border text-center">
                <thead className="bg-gray-200">
                  <tr>
                    <th>Nro</th>
                    <th>Día Pago</th>
                    <th>Fecha</th>
                    <th>Pago</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>Viernes</td>
                    <td>27 de Mayo de 2023</td>
                    <td>100.00</td>
                  </tr>
                </tbody>
              </table>
              <div className="mt-4 text-right">
                <button
                  type="submit"
                  className="bg-green-500 text-white font-bold py-2 px-4 rounded-md"
                >
                  Grabar Plan
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  );
};

export default Abonados;
