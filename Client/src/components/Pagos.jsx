import { useState } from "react";
import { toast } from "react-toastify";
import axios from "../config/axios-instance";
import Navbar from "./Navbar";
import Sidebar from "./Sidebar";

const Pagos = () => {
  const [filtros, setFiltros] = useState({
    codigo_plan: "",
    nombres: "",
    documento: "",
    placa: "",
    fecha: "",
    vencimiento: "",
  });

  const [resultados, setResultados] = useState([]);

  const handleChange = (e) => {
    setFiltros({
      ...filtros,
      [e.target.name]: e.target.value,
    });
  };

  const buscarPagos = async (e) => {
    e.preventDefault();
    try {
      const res = await axios.post("/pagos/buscar", filtros, {
        withCredentials: true,
      });

      if (res.data?.data) {
        setResultados(res.data.data);
        toast.success("Búsqueda completada");
      } else {
        toast.warn("No se encontraron resultados");
        setResultados([]);
      }
    } catch (error) {
      const msg =
        error.response?.data?.error || error.message || "Error al buscar pagos";
      toast.error(msg);
    }
  };

  return (
    <div>
      <Navbar />
      <div className="flex">
        <Sidebar />
        <div className="flex flex-col justify-center items-center mx-auto my-10 w-full max-w-5xl">
          <div className="bg-white shadow-md p-6 rounded-lg w-full">
            <form className="space-y-4" onSubmit={buscarPagos}>
              <div className="flex flex-wrap items-end gap-4">
                <button
                  type="submit"
                  className="bg-green-500 text-white font-bold py-2 px-6 rounded-md"
                >
                  Buscar
                </button>

                <input
                  name="codigo_plan"
                  value={filtros.codigo_plan}
                  onChange={handleChange}
                  type="text"
                  className="h-12 px-4 border rounded-md w-full md:w-48"
                  placeholder="Código del plan"
                />

                <input
                  name="nombres"
                  value={filtros.nombres}
                  onChange={handleChange}
                  type="text"
                  className="h-12 px-4 border rounded-md w-full md:w-48"
                  placeholder="Nombres/Apellidos"
                />

                <input
                  name="documento"
                  value={filtros.documento}
                  onChange={handleChange}
                  type="text"
                  className="h-12 px-4 border rounded-md w-full md:w-48"
                  placeholder="Documento"
                />

                <input
                  name="placa"
                  value={filtros.placa}
                  onChange={handleChange}
                  type="text"
                  className="h-12 px-4 border rounded-md w-full md:w-48 uppercase"
                  placeholder="Placa"
                />

                <input
                  name="fecha"
                  value={filtros.fecha}
                  onChange={handleChange}
                  type="date"
                  className="h-12 px-4 border rounded-md w-full md:w-48"
                />

                <input
                  name="vencimiento"
                  value={filtros.vencimiento}
                  onChange={handleChange}
                  type="date"
                  className="h-12 px-4 border rounded-md w-full md:w-48"
                />
              </div>
            </form>

            {/* Resultados */}
            <div className="mt-10">
              <h2 className="text-lg font-semibold mb-4">
                Resultados encontrados: {resultados.length}
              </h2>
              <table className="w-full text-sm border">
                <thead className="bg-gray-200">
                  <tr>
                    <th className="border px-2">#</th>
                    <th className="border px-2">Código</th>
                    <th className="border px-2">Nombre</th>
                    <th className="border px-2">Documento</th>
                    <th className="border px-2">Placa</th>
                    <th className="border px-2">Inicio</th>
                    <th className="border px-2">Fin</th>
                  </tr>
                </thead>
                <tbody>
                  {resultados.map((plan, i) => (
                    <tr key={plan.id}>
                      <td className="border px-2">{i + 1}</td>
                      <td className="border px-2">{plan.id}</td>
                      <td className="border px-2">
                        {plan.cliente?.nombre} {plan.cliente?.apellido}
                      </td>
                      <td className="border px-2">{plan.cliente?.cedula}</td>
                      <td className="border px-2">
                        {plan.vehiculo?.placa || "-"}
                      </td>
                      <td className="border px-2">{plan.fecha_inicio}</td>
                      <td className="border px-2">{plan.fecha_fin}</td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Pagos;
