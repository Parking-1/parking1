import Navbar from "./Navbar";
import Sidebar from "./Sidebar";

const Usuarios = () => {
  return (
    <div>
      <Navbar />
      <div className="flex">
        <Sidebar />
        <div className="flex flex-col w-full p-4">
          <div className="flex justify-center items-center h-full">
            <div className="flex flex-col items-center">
              <div className="flex items-center space-x-4">
                <h1 className="text-2xl font-bold">Usuarios</h1>
                <button className="bg-blue-500 text-white py-2 px-4 rounded">
                  Agregar Usuario
                </button>
              </div>
              {/* Aquí puedes agregar el contenido adicional de la página de usuarios */}
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Usuarios;
