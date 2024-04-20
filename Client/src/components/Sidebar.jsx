import React, { useState } from "react";
import Tarifas from "./Tarifas";
import Ingresos from "./Ingresos";
import Salidas from "./Salidas";
import Abonados from "./Abonados";
import Caja from "./Caja";
import Pagos from "./Pagos";
import Reportes from "./Reportes";
import Usuarios from "./Usuarios";
import {
  RiCurrencyLine,
  RiParkingBoxLine,
  RiDoorOpenLine,
  RiTeamLine,
  RiCashLine,
  RiWalletLine,
  RiBarChart2Line,
  RiUser3Line,
} from "react-icons/ri";

const Sidebar = () => {
  return (
    <div className="flex flex-col h-screen w-64 p-4 bg-secondary-500 border border-secondary-100">
      <div>
        <span>
          <RiCurrencyLine />
        </span>
        <Tarifas />
      </div>
      <div>
        <span>
          <RiParkingBoxLine />
        </span>
        <Ingresos />
      </div>
      <div>
        <span>
          <RiDoorOpenLine />
        </span>
        <Salidas />
      </div>
      <div>
        <span>
          <RiTeamLine />
        </span>
        <Abonados />
      </div>
      <div>
        <span>
          <RiCashLine />
        </span>
        <Caja />
      </div>
      <div>
        <span>
          <RiWalletLine />
        </span>
        <Pagos />
      </div>
      <div>
        <span>
          <RiBarChart2Line />
        </span>
        <Reportes />
      </div>
      <div>
        <span>
          <RiUser3Line />
        </span>
        <Usuarios />
      </div>
    </div>
  );
};

export default Sidebar;
