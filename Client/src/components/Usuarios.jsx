import { useState } from "react";
import Navbar from "./Navbar";
import Sidebar from "./Sidebar";

const Usuarios = () => {
  const [usuarios, setUsuarios] = useState([
    { id: 1, nombre: "Juan Pérez", rol: "Administrador" },
    { id: 2, nombre: "Ana Torres", rol: "Operador" },
  ]);

  const agregarUsuario = () => {
    const nuevoUsuario = {
      id: usuarios.length + 1,
      nombre: "Nuevo Usuario",
      rol: "Invitado",
    };
    setUsuarios([...usuarios, nuevoUsuario]);
  };

  return (
    <div>
      <Navbar />
      <div className="flex">
        <Sidebar />
        <div className="flex flex-col w-full p-4">
          <div className="flex justify-between items-center mb-6">
            <h1 className="text-2xl font-bold">Usuarios</h1>
            <button
              className="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600"
              onClick={agregarUsuario}
            >
              Agregar Usuario
            </button>
          </div>

          <table className="w-full table-auto border-collapse border border-gray-300">
            <thead className="bg-gray-200">
              <tr>
                <th className="border p-2">ID</th>
                <th className="border p-2">Nombre</th>
                <th className="border p-2">Rol</th>
                <th className="border p-2">Acciones</th>
              </tr>
            </thead>
            <tbody>
              {usuarios.map((usuario) => (
                <tr key={usuario.id}>
                  <td className="border p-2 text-center">{usuario.id}</td>
                  <td className="border p-2">{usuario.nombre}</td>
                  <td className="border p-2">{usuario.rol}</td>
                  <td className="border p-2 text-center space-x-2">
                    <button className="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                      Editar
                    </button>
                    <button className="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                      Eliminar
                    </button>
                  </td>
                </tr>
              ))}
              {usuarios.length === 0 && (
                <tr>
                  <td colSpan="4" className="text-center py-4 text-gray-500">
                    No hay usuarios registrados.
                  </td>
                </tr>
              )}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  );
};

export default Usuarios;
