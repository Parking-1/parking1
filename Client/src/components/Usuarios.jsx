import React, { useState, useEffect } from "react";
import axios from "axios";
import Navbar from "./Navbar";
import Sidebar from "./Sidebar";

const Usuarios = () => {
  return (
    <div>
      <Navbar />
      <div>
        <div className="flex">
          <Sidebar />
          <button>Nuevo Usuario</button>
          Usuarios
        </div>
      </div>
    </div>
  );
};

export default Usuarios;
