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
      <div className="flex flex-row items-center py-4 px-2 text-white text-xl">
        <span className="px-2">
          <RiCurrencyLine />
        </span>
        <Tarifas />
      </div>
      <div className="flex flex-row items-center py-4 px-2 text-white text-xl">
        <span className="px-2">
          <RiParkingBoxLine />
        </span>
        <Ingresos />
      </div>
      <div className="flex flex-row items-center py-4 px-2 text-white text-xl">
        <span className="px-2">
          <RiDoorOpenLine />
        </span>
        <Salidas />
      </div>
      <div className="flex flex-row items-center py-4 px-2 text-white text-xl">
        <span className="px-2">
          <RiTeamLine />
        </span>
        <Abonados />
      </div>
      <div className="flex flex-row items-center py-4 px-2 text-white text-xl">
        <span className="px-2">
          <RiCashLine />
        </span>
        <Caja />
      </div>
      <div className="flex flex-row items-center py-4 px-2 text-white text-xl">
        <span className="px-2">
          <RiWalletLine />
        </span>
        <Pagos />
      </div>
      <div className="flex flex-row items-center py-4 px-2 text-white text-xl">
        <span className="px-2">
          <RiBarChart2Line />
        </span>
        <Reportes />
      </div>
      <div className="flex flex-row items-center py-4 px-2 text-white text-xl">
        <span className="px-2">
          <RiUser3Line />
        </span>
        <Usuarios />
      </div>
    </div>
  );
};

export default Sidebar;
