import React, { useState } from "react";
import { Link } from "react-router-dom";

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
          <Link to="/ingresos">Ingresos</Link>
        </div>
        <div className="flex items-center py-4 px-2">
          <span className="px-2">
            <RiDoorOpenLine />
          </span>
          <Link to="/salidas">Salidas</Link>
        </div>
        <div className="flex items-center py-4 px-2">
          <span className="px-2">
            <RiTeamLine />
          </span>
          <Link to="/abonados">Abonados</Link>
        </div>
        <div className="flex items-center py-4 px-2">
          <span className="px-2">
            <RiCashLine />
          </span>
          <Link to="/caja">Caja</Link>
        </div>
        <div className="flex items-center py-4 px-2">
          <span className="px-2">
            <RiWalletLine />
          </span>
          <Link to="/pagos">Pagos</Link>
        </div>
        <div className="flex items-center py-4 px-2">
          <span className="px-2">
            <RiBarChart2Line />
          </span>
          <Link to="/reportes">Reportes</Link>
        </div>
        <div className="flex items-center py-4 px-2">
          <span className="px-2">
            <RiUser3Line />
          </span>
          <Link to="/usuarios">Usuarios</Link>
        </div>
      </div>
    </div>
  );
};

export default Sidebar;
