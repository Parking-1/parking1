import { Link } from "react-router-dom";
import { RiMore2Line } from "react-icons/ri";

const Navbar = () => {
  return (
    <nav className="h-[7vh] md:h-[10vh] border-b border-secondary-100 px-6 flex items-center justify-between bg-blue-500 text-white">
      <ul className="inline-flex items-center gap-4 text-xl">
        <li>
          <Link
            to="/home"
            title="Ir a la página principal"
            className="hover:underline"
          >
            Home
          </Link>
        </li>
      </ul>
      <div className="flex items-center gap-4">
        <Link
          to="/admin"
          title="Panel de administración"
          className="hover:underline"
        >
          Admin
        </Link>
        <RiMore2Line className="h-8 w-8 cursor-pointer" title="Más opciones" />
      </div>
    </nav>
  );
};

export default Navbar;
