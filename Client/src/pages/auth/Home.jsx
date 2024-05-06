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
        <div className="flex m-auto w-100 ">
          <div className="grid grid-cols-4 gap-16">
            <div className="text-2xl m-13 text-white  text-center border ">
              <div className="bg-blue-500 p-8">Estacionados Hoy</div>

              <img
                src={Garage}
                className="max-h-40 min-w-60 max-w-60 m-auto"
              ></img>
            </div>
            <div className="text-2xl m-13  text-center  text-white border ">
              <div className="bg-blue-500 p-8">Tarifas</div>
              <img
                src={barras}
                className="max-h-40 m-auto min-w-60 max-w-60"
              ></img>
            </div>
            <div className="text-2xl m-13  text-center  text-white border">
              <div className="bg-blue-500 p-8">Dinero en Caja</div>
              <img
                src={Cashbox}
                className="max-h-40 m-auto min-w-60 max-w-60"
              ></img>
            </div>
            <div className="text-2xl m-13  text-center text-white border">
              <div className="bg-blue-500 p-8"> Abonados</div>
              <img
                src={Team}
                className="max-h-40 m-auto min-w-60 max-w-60"
              ></img>
            </div>
          </div>
        </div>
      </div>
      <Footer />
    </div>
  );
};

export default Home;
