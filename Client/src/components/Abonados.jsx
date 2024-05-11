import React from "react";
import Navbar from "./Navbar";
import Sidebar from "./Sidebar";

const Abonados = () => {
  return (
    <div>
      <Navbar />
      <div className="flex flex-wrap">
        <Sidebar />
        <div className=" m-auto w-100">
          <div className=" w-100">
            <form className="w-100">
              <div className=" grid grid-rows grid-flow-col  w-100">
                <button className="bg-green-500 text-white font-bold py-2 px-4 rounded-md m-2  h-12">
                  Buscar Abonado
                </button>

                <input
                  className="h-12 px-4 py-2 rounded-lg border border-gray-300 text-lg uppercase m-2 "
                  type="text"
                  placeholder="Nombres y Apellidos"
                />
                <input
                  className="h-12 px-4 py-2 rounded-lg border border-gray-300 text-lg uppercase m-2"
                  type="text"
                  placeholder="Nro de Documento"
                />
                <input
                  className="h-12 px-4 py-2 rounded-lg border border-gray-300 text-lg uppercase m-2"
                  type="text"
                  placeholder="Placa de Vehiculo"
                />
              </div>
              <div className=" grid grid-rows grid-flow-col w-100 mt-10">
                <input
                  className="h-12 px-4 py-2 rounded-lg border border-gray-300 text-lg uppercase mb-4 mr-6 "
                  type="text"
                  placeholder="Monto x Sem. o Mes."
                />
                <select className=" h-12 px-4 py-2 rounded-lg border border-gray-300 text-lg uppercase mb-4 mr-6 ">
                  Duracion del Plan
                  <option>15 dias</option>
                  <option>30 dias</option>
                  <option>60 dias</option>
                </select>
                <select className=" h-12 px-4 py-2 rounded-lg border border-gray-300 text-lg uppercase mb-4 mr-6 ">
                  Tipo de Plan (Mensual - Semanal)
                  <option>Semanal</option>
                  <option>Mensual</option>
                </select>
                <button className="bg-green-500 text-white font-bold py-2 px-4 rounded-md mb-4 w-48 h-12">
                  Calcular Plan
                </button>
              </div>
              <div className=" grid grid-rows grid-flow-col  w-100">
                <input
                  className="h-12 px-4 py-2 rounded-lg border border-gray-300 text-lg uppercase mb-4 mr-6"
                  type="date"
                  placeholder="Fecha de Inicio del Plan"
                />
                <input
                  className="w-1/4 h-12 px-4 py-2 rounded-lg border border-gray-300 text-lg uppercase mb-4 mr-6"
                  type="number"
                  placeholder="Total del Plan"
                />
              </div>
              <div className=" grid grid-rows grid-flow-col  w-100">
                <table>
                  <thead>
                    <td>Nro</td>
                    <td>Dia Pago</td>
                    <td>Fecha</td>
                    <td>Pago</td>
                  </thead>
                  <tbody>
                    <td>1</td>
                    <td>Viernes</td>
                    <td>27 de Mayo de 2023</td>
                    <td>100.00</td>
                  </tbody>
                </table>
                <button className="bg-green-500 text-white font-bold py-2 px-4 rounded-md mt-6 mb-2 w-48 h-12">
                  Grabar Plan
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Abonados;
