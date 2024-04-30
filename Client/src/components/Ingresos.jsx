import React, { useState, useEffect } from "react";
import axios from "axios";

const Ingresos = () => {
  return (
    <div>
      <form>
        <label>Ingrese placa o matrícula del vehículo</label>
        <textarea placeholder="Ingrese placa o matrícula del vehículo"></textarea>
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
        <button>Click aqui si quiere borrar el ingreso</button>
      </form>
    </div>
  );
};

export default Ingresos;
