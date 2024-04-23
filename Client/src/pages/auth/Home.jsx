import Navbar from "../../components/Navbar";
import Sidebar from "../../components/Sidebar";


const Home = () => {
  return (
    <>
    <div  >
      <Navbar />
      <Sidebar />
    </div>
      <div className=" flex flex-col items-center justify-center flex-grow">
      <h1>Vehiculos Estacionados Hoy</h1>
      <h1>Tarifas</h1>
      <h1>Dinero en Caja</h1>
      <h1>Abonados</h1>
      </div>
    </>
  );
};

export default Home;
