import React, { useState, useEffect } from "react";
import axios from "axios";
import Navbar from "./Navbar";
import Sidebar from "./Sidebar";

const Tarifas = () => {
  const url = "http://localhost:8000/api/tarifa";
  const [tarifa, setTarifa] = useState([]);

  useEffect(() => {
    getTarifas();
  }, []);

  const getTarifas = async () => {
    const respuesta = await axios.get(url);
    //setTarifas(respuesta.data);
  };

  return (
    <div>
      <Navbar />
      <div className="flex">
        <Sidebar />
        <div className="flex flex-col justify-center items-center mx-auto my-30">
          <div className="flex">
            <div className="mr-40">
              <form
                className="flex flex-col items-center justify-center"
                onSubmit={() => alert("submitting")}
              >
                <input
                  type="text"
                  placeholder="Clase de Vehiculo"
                  className="mb-6 w-48 py-2 px-4"
                  onChange={(e) => setTarifa(e.target.value)}
                />
                <input
                  type="text"
                  placeholder="Precio por Hora"
                  className="mb-6 w-48 py-2 px-4"
                />
                <input
                  type="text"
                  placeholder="Precio por Dia"
                  className="mb-6 w-48 py-2 px-4"
                />
                <input
                  type="text"
                  placeholder="Precio por Lavado"
                  className="mb-6 w-48 py-2 px-4"
                />
                <div className="flex flex-col gap-2">
                  <button className="bg-green-500 text-white font-bold py-2 px-4 rounded-md mt-6 mb-2 w-48">
                    Agregar Tarifa
                  </button>
                  <button className="bg-blue-500 text-white font-bold py-2 px-4 rounded-md mt-2 mb-2 w-48">
                    Editar Tarifa
                  </button>
                </div>
              </form>
            </div>
            <div>
              <table className="border-solid bg-slate-50 w-100 h-80">
                <thead className="flex flex-row gap-6 text-white font-bold py-2 px-4 bg-blue-400 ">
                  <div>Clase de Vehiculo</div>
                  <div>Precio por hora o fraccion</div>
                  <div>Precio por Dia</div>
                  <div>Precio Adicional</div>
                </thead>
                <tbody></tbody>
              </table>
              <div className="flex items-center justify-center">
                <button className="bg-red-500 text-white font-bold py-2 px-4 rounded-md mt-6 w-48">
                  Eliminar
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Tarifas;
