import React, { useState, useEffect } from "react";
import axios from "axios";

const Tarifas = () => {
  const url = "http://localhost:8000/api/tarifa";
  const [tarifas, setTarifas] = useState([]);
  const [id, setId] = useState("");
  const [tipo, setTipo] = useState("");
  const [descripcion, setDescripcion] = useState("");
  const [operacion, setOperacion] = useState("");

  useEffect(() => {
    getTarifas();
  }, []);

  const getTarifas = async () => {
    const respuesta = await axios.get(url);
    setTarifas(respuesta.data);
  };

  return <div className="">Tarifas</div>;
};

export default Tarifas;
