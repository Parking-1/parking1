import { useState, useEffect } from "react";
import axios from "../config/axios-instance"; // Asegúrate de tener esta instancia configurada
import Navbar from "./Navbar";
import Sidebar from "./Sidebar";

const Usuarios = () => {
  const [usuarios, setUsuarios] = useState([]);

  useEffect(() => {
    fetchUsuarios();
  }, []);

  const fetchUsuarios = async () => {
    try {
      const res = await axios.get("/usuarios");
      setUsuarios(res.data.data);
    } catch (err) {
      console.error("Error al obtener usuarios:", err);
    }
  };

  const eliminarUsuario = async (id) => {
    try {
      await axios.delete(`/usuarios/${id}`);
      setUsuarios((prev) => prev.filter((u) => u.id !== id));
    } catch (err) {
      console.error("Error al eliminar usuario:", err);
    }
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
              onClick={fetchUsuarios}
            >
              Recargar
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
                  <td className="border p-2">{usuario.name}</td>
                  <td className="border p-2">
                    {usuario.roles?.map((r) => r.nombre).join(", ") || "-"}
                  </td>
                  <td className="border p-2 text-center space-x-2">
                    <button className="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                      Editar
                    </button>
                    <button
                      onClick={() => eliminarUsuario(usuario.id)}
                      className="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                    >
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
