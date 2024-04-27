import React, { useState, useEffect } from "react";
import axios from "axios";

const Ingresos = () => {
  return (
    <div>
      <form>
        <h1>Ingrese placa o matrícula del vehículo</h1>
        <textarea></textarea>
        <div>
          <label>Seleccione clase de vehículo</label>
          <select>
            <option value="auto">Auto</option>
            <option value="moto">Moto</option>
            <option value="camion">Camión</option>
            <option value="bus">Bus</option>
          </select>
          <div>Hora</div>
          <div>Fecha</div>
        </div>
        <button>Ingresar</button>
      </form>
    </div>
  );
};

export default Ingresos;
