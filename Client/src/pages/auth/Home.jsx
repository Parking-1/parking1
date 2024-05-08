import Navbar from "../../components/Navbar";
import Sidebar from "../../components/Sidebar";
import barras from "./../../assets/barras.png";
import Garage from "../../assets/Garage-removebg-preview.png";
import Team from "../../assets/team-removebg-preview.png";
import Cashbox from "../../assets/Cashbox.png";
import Footer from "../../components/Footer";
import { Link } from "react-router-dom";

const Home = () => {
  return (
    <div>
      <Navbar />
      <div className="flex">
        <div className="flex flex-col my-160">
          <Sidebar />
        </div>
        <div className="flex m-auto w-full ">
          <div className="grid grid-cols-4 gap-10 ml-40">
            <div className="text-2xl m-13 text-white text-center border">
              <div className="flex flex-col items-center justify-center h-full">
              <div className="w-full bg-blue-500 p-8">
                <Link to="/ingresos" className="bg-blue-500 p-8">
                  Estacionados Hoy
                </Link>
                </div>
                <img
                  src={Garage}
                  className="max-h-40 min-w-60 max-w-60 m-auto"
                  alt="Garage"
                />
              </div>
            </div>
            <div className="text-2xl m-1 text-center text-white border">
              <div className="flex flex-col items-center justify-center h-full">
                <div className="w-full bg-blue-500 p-8">
                  <Link to="/tarifas" className=" ">
                    Tarifas
                  </Link>
                </div>

                <img
                  src={barras}
                  className="max-h-40 min-w-60 max-w-60 m-auto"
                  alt="Barras"
                />
              </div>
            </div>
            <div className="text-2xl m-13 text-center text-white border">
              <div className="flex flex-col items-center justify-center h-full">
              <div className="w-full bg-blue-500 p-8">
                <Link to="/caja" className="bg-blue-500 p-8">
                  Dinero en Caja
                </Link>
                </div>
                <img
                  src={Cashbox}
                  className="max-h-40 min-w-60 max-w-60 m-auto"
                  alt="Cashbox"
                />
              </div>
            </div>
            <div className="text-2xl m-13 text-center text-white border">
              <div className="flex flex-col items-center justify-center h-full">
              <div className="w-full bg-blue-500 p-8">
                <Link to="/abonados" className="bg-blue-500 p-8">
                  Abonados
                </Link>
                </div>
                <img
                  src={Team}
                  className="max-h-40 min-w-60 max-w-60 m-auto"
                  alt="Team"
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
