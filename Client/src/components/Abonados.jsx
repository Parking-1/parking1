import React, { useState, useEffect } from "react";
import axios from "axios";
import Navbar from "./Navbar";
import Sidebar from "./Sidebar";

const Abonados = () => {
  return (
    <div>
      <Navbar />
      <div>
        <div className="flex">
          <Sidebar />
          <form>
            <buton></buton>
            <input></input>
            <input></input>
            <input></input>
            <input></input>
            <select></select>
            <select></select>
            <option></option>
            <button></button>
            <input></input>
            <input></input>
            <table></table>
            <button></button>
          </form>
        </div>
      </div>
    </div>
  );
};

export default Abonados;
