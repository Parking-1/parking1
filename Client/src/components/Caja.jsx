import React, { useState, useEffect } from "react";
import axios from "axios";
import Navbar from "./Navbar";
import Sidebar from "./Sidebar";

const Caja = () => {
  return (
    <div>
      <Navbar />
        <div className="flex">
          <Sidebar />
          <div className=" m-auto w-100 mt-10">
            <div className=" w-100 ">
          <h1 className="">Efectivo Neto en Caja: </h1>
          <h1 className="">Moneda: </h1>
          <form className="w-100">
            <h1 className="mt-4 mb-2 border-b pb-2">Ingresos</h1>
          <div  className=" flex flex-row grid-flow-col gap-10 mt-6">
            <input placeholder="Ingrese Monto" type="text" className="h-12"/>
            <button className="bg-blue-500 text-white font-bold py-2 px-4 rounded-md mt-2 mb-2 w-48">Agregar dinero en Caja</button>
          </div>
          <h1 className="mt-4 mb-2 border-b pb-2">Egresos</h1>
          <div  className=" flex flex-row grid-flow-col gap-10 mt-6">
            <input placeholder="Motivo del Retiro" type="text" className="h-12"/>
            <button className="bg-blue-500 text-white font-bold py-2 px-4 rounded-md mt-2 mb-2 w-48">Retirar dinero en Caja</button>
          </div>
          <div  className=" flex flex-row grid-flow-col gap-10 mt-6">
            <input placeholder="Ingrese Monto" type="text" className="h-12"/>
          </div>
          <h1 className="mt-4 mb-2 border-b pb-2">Movimientos de Caja - Filtros</h1>
          <div  className=" flex flex-row grid-flow-col gap-10 mt-6 ">
            <input type="date" placeholder="Fecha Inicio" className="px-10"/>
            <button className="bg-blue-500 text-white font-bold py-2 px-4 rounded-md mt-2 mb-2 w-48">Ingresos Caja</button>
          </div>
          <div  className=" flex flex-row grid-flow-col gap-10 mt-6">
            <input type="date" placeholder="Fecha Final" className="px-10"/>
            <button className="bg-blue-500 text-white font-bold py-2 px-4 rounded-md mt-2 mb-2 w-48">Egresos Caja</button>
          </div>
          <div  className=" flex flex-col grid-flow-col gap-10 mt-6 ml-64">
            <button className="bg-blue-500 text-white font-bold py-2 px-4 rounded-md mt-2 mb-2 w-48">Movimientos Caja</button>
          </div>
          </form>
              </div>
          </div>
          </div>
        </div>
  );
};

export default Caja;
