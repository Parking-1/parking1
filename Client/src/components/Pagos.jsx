import React from "react";
import Navbar from "./Navbar";
import Sidebar from "./Sidebar";

const Pagos = () => {
  return (
    <div>
      <Navbar />
      <div className="flex">
        <Sidebar />
        <div className="flex flex-col justify-center items-center mx-auto my-30">
          <div className="flex">
            <div className="mr-40">
              <form>
                <div className="flex items-center mb-4">
                  <button className="bg-green-500 text-white font-bold py-2 px-4 rounded-md mr-4">
                    Buscar
                  </button>
                  <div className="flex flex-col">
                    <h1>Código del plan</h1>
                    <input type="text" className="w-full" />
                  </div>
                </div>
                <h1 className="mb-2">Nombres y Apellidos</h1>
                <input type="text" className="w-full mb-2" />
                <h1 className="mb-2">Documento</h1>
                <input type="text" className="w-full mb-2" />
                <h1 className="mb-2">Placa del Vehiculo</h1>
                <input type="text" className="w-full mb-2" />
                <h1 className="mb-2">Fecha</h1>
                <input type="text" className="w-full mb-2" />
                <h1 className="mb-2">Fecha de Vencimiento del plan</h1>
                <input type="text" className="w-full mb-2" />
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Pagos;
