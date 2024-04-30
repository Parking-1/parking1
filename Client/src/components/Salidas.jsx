import React, { useState, useEffect } from "react";
import axios from "axios";

const Salidas = () => {
  return (
    <div>
      <form>
        <label>Buscar por placa</label>
        <input type="text" />
        <label>Buscar por numero de ticket</label>
        <input type="text" />
        <div>Placa: </div>
        <div>Hora de Entrada</div>
        <div>Fecha de Entrada</div>
        <div>Clase de Vehiculo</div>
        <div>Tiempo Transcurrido</div>
        <div>Hora de Salida</div>
        <div>Fecha de Salida</div>
        <div>Cobro por Parking</div>
        <div>Cobro por Lavado</div>
        <option>
          <checkbox>Si Lavado</checkbox>
          <checkbox>No Lavado</checkbox>
        </option>
        <button>Ir a pagar</button>
      </form>
    </div>
  );
};

export default Salidas;
