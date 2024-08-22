
import { Link } from "react-router-dom";
import { RiMore2Line } from "react-icons/ri";

const Navbar = () => {

  return (
    <nav className="h-[7vh] md:h-[10vh] border-b border-secondary-100 p-8 flex items-center justify-between bg-blue-500">
      <ul className="inline-flex text-xl flex-grow">
        <li>
          <Link to="/home" className="flex items-center">
            Home
          </Link>
        </li>
      </ul>
      <div className="flex items-center">
        <Link to="/admin" className="p-3 flex mr-4">
          Admin
        </Link>
        <RiMore2Line className="h-8 w-8" />
      </div>
    </nav>
  );
};

export default Navbar;
