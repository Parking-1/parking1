import Navbar from "../../components/Navbar";
import Sidebar from "../../components/Sidebar";
import barras from "../../assets/barras.png";
import Garage from "../../assets/Garage-removebg-preview.png";
import Team from "../../assets/team-removebg-preview.png";
import Cashbox from "../../assets/Cashbox.png";
import Footer from "../../components/Footer";
import { Link } from "react-router-dom";

const Home = () => {
  return (
    <div className="min-h-screen flex flex-col bg-gray-100">
      <Navbar />
      <div className="flex flex-1">
        <Sidebar />
        <div className="w-full p-10">
          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {/* Estacionados Hoy */}
            <div className="bg-white rounded-lg shadow-md text-center">
              <div className="bg-blue-500 text-white py-4 text-xl font-semibold rounded-t-lg">
                <Link to="/ingresos">Estacionados Hoy</Link>
              </div>
              <div className="p-4">
                <img
                  src={Garage}
                  alt="Vehículos estacionados"
                  className="max-h-40 mx-auto"
                />
              </div>
            </div>

            {/* Tarifas */}
            <div className="bg-white rounded-lg shadow-md text-center">
              <div className="bg-blue-500 text-white py-4 text-xl font-semibold rounded-t-lg">
                <Link to="/tarifas">Tarifas</Link>
              </div>
              <div className="p-4">
                <img src={barras} alt="Tarifas" className="max-h-40 mx-auto" />
              </div>
            </div>

            {/* Dinero en Caja */}
            <div className="bg-white rounded-lg shadow-md text-center">
              <div className="bg-blue-500 text-white py-4 text-xl font-semibold rounded-t-lg">
                <Link to="/caja">Dinero en Caja</Link>
              </div>
              <div className="p-4">
                <img
                  src={Cashbox}
                  alt="Dinero en caja"
                  className="max-h-40 mx-auto"
                />
              </div>
            </div>

            {/* Abonados */}
            <div className="bg-white rounded-lg shadow-md text-center">
              <div className="bg-blue-500 text-white py-4 text-xl font-semibold rounded-t-lg">
                <Link to="/abonados">Abonados</Link>
              </div>
              <div className="p-4">
                <img
                  src={Team}
                  alt="Usuarios abonados"
                  className="max-h-40 mx-auto"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
      <Footer />
    </div>
  );
};

export default Home;
