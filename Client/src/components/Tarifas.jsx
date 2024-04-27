import React, { useState, useEffect } from "react";
import axios from "axios";

const Tarifas = () => {
  const url = "http://localhost:8000/api/tarifa";
  const [tarifa, setTarifa] = useState([]);
  /* const [id, setId] = useState("");
  const [tipo, setTipo] = useState("");
  const [descripcion, setDescripcion] = useState("");
  const [operacion, setOperacion] = useState(""); */

  useEffect(() => {
    getTarifas();
  }, []);

  const getTarifas = async () => {
    const respuesta = await axios.get(url);
    //setTarifas(respuesta.data);
  };

  return (
    <div>
      <h1 className="mb-4">Tarifas</h1>
      <form className="flex flex-col" onSubmit={() => alert("submitting")}>
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
        <input type="text" placeholder="Precio por Dia" className="mb-2 w-48" />
        <input
          type="text"
          placeholder="Precio por Lavado"
          className="mb-2 w-48"
        />
        <button className="mt-2">Agregar Tarifa</button>
        <button className="mt-2">Editar Tarifa</button>
        <button className="mt-2">Eliminar</button>
      </form>
    </div>
  );
};

export default Tarifas;
