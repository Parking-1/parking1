import React, { useState, useEffect } from "react";
import axios from "axios";
import Navbar from "./Navbar";
import Sidebar from "./Sidebar";

const Ingresos = () => {
  return (
    <div>
      <Navbar />
      <div>
        <div className="flex">
          <Sidebar />
          <div className="flex flex-col justify-center items-center mx-auto my-30">
            <form>
              <h1>Ingrese placa o matrícula del vehículo</h1>
              <input
                className="w-full h-40 px-4 py-2 rounded-lg border border-gray-300 text-4xl uppercase mx-100%"
                type="text"
                placeholder="Ingrese placa o matrícula del vehículo"
              />
              <div>
                <h1>Seleccione clase de vehículo</h1>
                <select className="flex flex-col w-60 h-10 px-4 py-2 rounded-lg border">
                  <option value="auto">Auto</option>
                  <option value="moto">Moto</option>
                  <option value="camion">Camión</option>
                  <option value="bus">Bus</option>
                </select>
                <div className="flex flex-row mt-4">Hora</div>
                <div className="flex flex-row mt-4">Fecha</div>
              </div>
              <button className="bg-green-500 text-white font-bold py-2 px-4 rounded-md mt-6 mb-2 w-48">
                Ingresar
              </button>
              <button className="flex flex-col text-blue">
                Click aqui si quiere borrar el ingreso
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Ingresos;
