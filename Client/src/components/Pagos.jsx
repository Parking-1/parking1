import React, { useState, useEffect } from "react";
import axios from "axios";
import Navbar from "./Navbar";
import Sidebar from "./Sidebar";

const Pagos = () => {
  return (
    <div>
      <Navbar />
      <div>
        <div className="flex">
          <Sidebar />
          <form>
            <button></button>
            <input />
            <input />
            <input />
            <input />
            <input />
            <input />
          </form>
        </div>
      </div>
    </div>
  );
};

export default Pagos;
