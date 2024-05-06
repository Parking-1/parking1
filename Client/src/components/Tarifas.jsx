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
      <div>
        <div className="flex">
          <Sidebar />
          <div className="flex flex-col justify-center items-center mx-auto my-8">
            <form
              className="flex flex-col items-center justify-center"
              onSubmit={() => alert("submitting")}
            >
              <h1 className="mb-4">Tarifas</h1>
              <input
                type="text"
                placeholder="Clase de Vehiculo"
                className="mb-2 w-48"
                onChange={(e) => setTarifa(e.target.value)}
              />
              <input
                type="text"
                placeholder="Precio por Hora"
                className="mb-2 w-48"
              />
              <input
                type="text"
                placeholder="Precio por Dia"
                className="mb-2 w-48"
              />
              <input
                type="text"
                placeholder="Precio por Lavado"
                className="mb-2 w-48"
              />
              <div className="flex">
                <button className="mr-2">Agregar Tarifa</button>
                <button className="mr-2">Editar Tarifa</button>
                <button>Eliminar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Tarifas;
