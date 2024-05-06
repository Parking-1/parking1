import React, { useState, useEffect } from "react";
import axios from "axios";
import Navbar from "./Navbar";
import Sidebar from "./Sidebar";

const Caja = () => {
  return (
    <div>
      <Navbar />
      <div>
        <div className="flex">
          <Sidebar />
          <h1>Efectivo Neto en Caja: </h1>
          <form>
            <input />
            <button>Agregar dinero en Caja</button>
            <input />
            <input />
            <button>Retirar dinero en Caja</button>
            <input />
            <input />
            <button>Ingresos Caja</button>
            <button>Egresos Caja</button>
            <button>Movimientos Caja</button>
          </form>
        </div>
      </div>
    </div>
  );
};

export default Caja;
