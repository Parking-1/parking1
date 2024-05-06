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
          <button>Listar Tickets</button>
          <button>Salidas de Vehiculos</button>
          <button>Vehiculos Estacionados</button>
          <button>Pagos de Tickets</button>
        </div>
      </div>
    </div>
  );
};

export default Reportes;
