import { NavLink } from "react-router-dom";
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

const menuItems = [
  { path: "/tarifas", label: "Tarifas", icon: <RiCurrencyLine /> },
  { path: "/ingresos", label: "Ingresos", icon: <RiParkingBoxLine /> },
  { path: "/salidas", label: "Salidas", icon: <RiDoorOpenLine /> },
  { path: "/abonados", label: "Abonados", icon: <RiTeamLine /> },
  { path: "/caja", label: "Caja", icon: <RiCashLine /> },
  { path: "/pagos", label: "Pagos", icon: <RiWalletLine /> },
  { path: "/reportes", label: "Reportes", icon: <RiBarChart2Line /> },
  { path: "/usuarios", label: "Usuarios", icon: <RiUser3Line /> },
];

const Sidebar = () => {
  return (
    <div className="relative top-18 left-0 h-full w-64 p-4 bg-gray-500 border-r border-gray-300">
      <div className="flex flex-col text-white text-lg space-y-2">
        {menuItems.map((item) => (
          <NavLink
            key={item.path}
            to={item.path}
            className={({ isActive }) =>
              `flex items-center py-3 px-3 rounded transition hover:bg-gray-600 ${
                isActive ? "bg-gray-700 font-bold" : ""
              }`
            }
          >
            <span className="text-2xl mr-3">{item.icon}</span>
            {item.label}
          </NavLink>
        ))}
      </div>
    </div>
  );
};

export default Sidebar;
