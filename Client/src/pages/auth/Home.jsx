import Navbar from "../../components/Navbar";
import Sidebar from "../../components/Sidebar";

const Home = () => {
  return (
    <div>
      <Navbar />
      <div className="flex">
        <div className="flex flex-col my-160">
          <Sidebar />
        </div>
        <div className="flex m-auto w-100 ">
          <div className="grid grid-cols-4 gap-4">
            <div className="text-2xl m-12 text-white p-8 text-center border border-sky-500">
              Vehiculos Estacionados Hoy
            </div>
            <div className="text-2xl m-12  text-center  text-white p-12 border border-sky-500">
              Tarifas
            </div>
            <div className="text-2xl m-12  text-center  text-white p-12 border border-sky-500">
              Dinero en Caja
            </div>
            <div className="text-2xl m-12  text-center text-white p-12 border border-sky-500">
              Abonados
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Home;
