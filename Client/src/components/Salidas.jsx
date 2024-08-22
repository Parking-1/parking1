import Navbar from "./Navbar";
import Sidebar from "./Sidebar";

const Salidas = () => {
  return (
    <div>
      <Navbar />
      <div className="flex">
        <Sidebar />
        <div className="flex flex-col justify-center items-center mx-auto my-30">
          <div className="flex">
            <div className="w-1/3 pr-8">
              {" "}
              {/* Columna de los inputs */}
              <form className="flex flex-col">
                <label>Buscar por placa</label>
                <input type="text" className="mb-6 w-48 py-2 px-4" />
                <label>Buscar por Nro de ticket</label>
                <input type="text" className="mb-6 w-48 py-2 px-4" />
              </form>
            </div>
            <div className="w-2/3 p-4 ml-8">
              {" "}
              {/* Columna de los otros divs */}
              <div className="grid grid-cols-2 gap-6 ">
                <div>Placa:</div>
                <div className="ml-4">Hora de Salida:</div>
                <div>Hora de Entrada:</div>
                <div className="ml-4">Fecha de Salida:</div>
                <div>Fecha de Entrada:</div>
                <div className="ml-4">Cobro por Parking:</div>
                <div>Clase de Vehiculo:</div>
                <div className="ml-4">Cobro por Lavado:</div>
                <div>Tiempo Transcurrido:</div>
                <div>
                  <div className="flex flex-row ml-4">
                    <input type="checkbox" />
                    <label htmlFor="parking">Servicio Adicional</label>
                  </div>
                  <div className="flex flex-row ml-4">
                    <input type="checkbox" />
                    <label htmlFor="lavado">No Servicio Adicional</label>
                  </div>
                </div>
              </div>
              <button className="bg-green-500 text-white font-bold py-2 px-4 rounded-md mt-6 mb-2 w-48">
                Ir a pagar
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Salidas;
