import React, { useState, useEffect } from "react";
import axios from "axios";
import Navbar from "./Navbar";
import Sidebar from "./Sidebar";

const Reportes = () => {
  return (
    <div>
      <Navbar />
      <div>
        <div className="flex">
          <Sidebar />
          <div className="flex flex-col w-full p-4">
            <div className="flex justify-center space-x-4 mb-8 items-end mt-12">
              <div className="flex flex-col w-1/3">
                <label className="mb-1 text-center">Fecha de Inicio</label>
                <input type="date" className="border p-2 rounded w-full" />
              </div>
              <div className="flex flex-col w-1/3">
                <label className="mb-1 text-center">Fecha Final</label>
                <input type="date" className="border p-2 rounded w-full" />
              </div>
              <button className="bg-blue-500 text-white py-2 px-4 rounded h-11">
                Mostrar
              </button>
            </div>
            <div className="flex justify-center items-center h-full">
              <div className="flex flex-col space-y-4">
                <button className="bg-blue-500 text-white py-2 px-4 rounded">
                  Listar Tickets
                </button>
                <button className="bg-blue-500 text-white py-2 px-4 rounded">
                  Salidas de Vehiculos
                </button>
                <button className="bg-blue-500 text-white py-2 px-4 rounded">
                  Vehiculos Estacionados
                </button>
                <button className="bg-blue-500 text-white py-2 px-4 rounded">
                  Pagos de Tickets
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Reportes;
