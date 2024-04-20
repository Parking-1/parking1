import React, { useState } from "react";
import { RiMore2Line } from "react-icons/ri";

const Navbar = () => {
  return (
    <nav className=" h-[7vh] md:h-[10vh] border-b border-secondary-100 p-8 flex items-center justify-between bg-blue-500">
      <ul className="inline-flex">
        <li className="p-3">Home</li>
        <li className="p-3">Admin</li>
      </ul>
      <RiMore2Line className="h-8 w-8 " />
    </nav>
  );
};

export default Navbar;
