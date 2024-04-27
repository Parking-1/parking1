import React, { useState } from "react";
import { Link } from "react-router-dom";
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
    <div className="relative top-18 left-0 h-full w-64 p-4 bg-gray-500 border border-secondary-100">
      <div className="flex flex-col text-white text-xl">
        <div className="flex items-center py-4 px-2">
          <span className="px-2">
            <RiCurrencyLine />
          </span>
          <Link to="/tarifas">Tarifas</Link>
        </div>
        <div className="flex items-center py-4 px-2">
          <span className="px-2">
            <RiParkingBoxLine />
          </span>
          <Ingresos />
        </div>
        <div className="flex items-center py-4 px-2">
          <span className="px-2">
            <RiDoorOpenLine />
          </span>
          <Salidas />
        </div>
        <div className="flex items-center py-4 px-2">
          <span className="px-2">
            <RiTeamLine />
          </span>
          <Abonados />
        </div>
        <div className="flex items-center py-4 px-2">
          <span className="px-2">
            <RiCashLine />
          </span>
          <Caja />
        </div>
        <div className="flex items-center py-4 px-2">
          <span className="px-2">
            <RiWalletLine />
          </span>
          <Pagos />
        </div>
        <div className="flex items-center py-4 px-2">
          <span className="px-2">
            <RiBarChart2Line />
          </span>
          <Reportes />
        </div>
        <div className="flex items-center py-4 px-2">
          <span className="px-2">
            <RiUser3Line />
          </span>
          <Usuarios />
        </div>
      </div>
    </div>
  );
};

export default Sidebar;
