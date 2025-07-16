import { useState, useEffect } from "react";
import axios from "../config/axios-instance.jsx";
import Navbar from "./Navbar";
import Sidebar from "./Sidebar";
import { toast } from "react-toastify";

const Tarifas = () => {
  const url = "http://parking.local:8080/api/tarifa-all";
  const [tarifas, setTarifas] = useState([]);
  const [tiposVehiculo, setTiposVehiculo] = useState([]);
  const [loading, setLoading] = useState(false);
  const [editingId, setEditingId] = useState(null);

  const [formValues, setFormValues] = useState({
    claseVehiculo: "",
    precioHora: "",
    precioDia: "",
    precioLavado: "",
  });

  useEffect(() => {
    fetchTarifas();
    fetchTiposVehiculo();
  }, []);

  const fetchTarifas = async () => {
    try {
      const response = await axios.get(url);
      setTarifas(response.data.data || []);
    } catch (error) {
      console.error("Error al obtener tarifas", error);
      toast.error("No se pudieron cargar las tarifas");
    }
  };

  const fetchTiposVehiculo = async () => {
    try {
      const response = await axios.get(
        "http://localhost:8080/api/tipos-vehiculo"
      );
      setTiposVehiculo(response.data.data || []);
    } catch (error) {
      console.error("Error al obtener tipos de vehículo", error);
      toast.error("No se pudieron cargar los tipos de vehículo");
    }
  };

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormValues({ ...formValues, [name]: value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    const { claseVehiculo, precioHora, precioDia, precioLavado } = formValues;

    // Validar los campos requeridos
    if (
      [precioHora, precioDia].some((v) => isNaN(v) || v === "") ||
      claseVehiculo === ""
    ) {
      toast.error("Completa todos los campos requeridos correctamente.");
      return;
    }

    const nuevaTarifa = {
      id_tipo_vehiculo: claseVehiculo,
      tipo_tarifa: "hora",
      precio_base: precioHora,
      precio_dia: precioDia,
      precio_lavado: precioLavado === "" ? null : precioLavado,
    };

    setLoading(true);

    try {
      if (editingId) {
        const response = await axios.put(`${url}/${editingId}`, nuevaTarifa);
        setTarifas((prev) =>
          prev.map((t) => (t.id === editingId ? response.data.data : t))
        );
        toast.success("Tarifa actualizada correctamente");
        setEditingId(null);
      } else {
        const response = await axios.post(url, nuevaTarifa);
        setTarifas((prev) => [...prev, response.data.data]);
        toast.success("Tarifa creada correctamente");
      }

      setFormValues({
        claseVehiculo: "",
        precioHora: "",
        precioDia: "",
        precioLavado: "",
      });
    } catch (error) {
      console.error("Error al guardar la tarifa", error);
      toast.error("Error al guardar la tarifa");
    }

    setLoading(false);
  };

  const handleEdit = (tarifa) => {
    setFormValues({
      claseVehiculo: tarifa.id_tipo_vehiculo,
      precioHora: tarifa.precio_base,
      precioDia: tarifa.precio_dia,
      precioLavado: tarifa.precio_lavado ?? "",
    });
    setEditingId(tarifa.id);
  };

  const handleDelete = async (id) => {
    try {
      await axios.delete(`${url}/${id}`);
      setTarifas((prev) => prev.filter((t) => t.id !== id));
      toast.success("Tarifa eliminada correctamente");
    } catch (error) {
      console.error("Error al eliminar la tarifa", error);
      toast.error("Error al eliminar la tarifa");
    }
  };

  return (
    <div>
      <Navbar />
      <div className="flex">
        <Sidebar />
        <div className="flex flex-col justify-center items-center mx-auto my-12 w-full">
          <div className="flex flex-col md:flex-row w-full max-w-6xl p-6 gap-8">
            {/* Formulario */}
            <form onSubmit={handleSubmit} className="w-full md:w-1/3 space-y-4">
              <select
                name="claseVehiculo"
                value={formValues.claseVehiculo}
                onChange={handleChange}
                className="w-full py-2 px-4 border rounded"
              >
                <option value="">Seleccione tipo de vehículo</option>
                {tiposVehiculo.map((tipo) => (
                  <option key={tipo.id} value={tipo.id}>
                    {tipo.descripcion}
                  </option>
                ))}
              </select>

              <input
                type="text"
                name="precioHora"
                placeholder="Precio por Hora *"
                className="w-full py-2 px-4 border rounded"
                value={formValues.precioHora}
                onChange={handleChange}
              />
              <input
                type="text"
                name="precioDia"
                placeholder="Precio por Día *"
                className="w-full py-2 px-4 border rounded"
                value={formValues.precioDia}
                onChange={handleChange}
              />
              <input
                type="text"
                name="precioLavado"
                placeholder="Precio por Lavado (opcional)"
                className="w-full py-2 px-4 border rounded"
                value={formValues.precioLavado}
                onChange={handleChange}
              />
              <button
                type="submit"
                disabled={loading}
                className="w-full bg-green-500 text-white py-2 rounded hover:bg-green-600"
              >
                {editingId
                  ? loading
                    ? "Actualizando..."
                    : "Actualizar Tarifa"
                  : loading
                  ? "Guardando..."
                  : "Agregar Tarifa"}
              </button>
            </form>

            {/* Tabla */}
            <div className="w-full md:w-2/3 overflow-x-auto">
              <table className="w-full bg-white border border-gray-200 shadow-md">
                <thead className="bg-blue-400 text-white">
                  <tr>
                    <th className="p-2">Clase Vehículo</th>
                    <th className="p-2">Precio Hora</th>
                    <th className="p-2">Precio Día</th>
                    <th className="p-2">Precio Lavado</th>
                    <th className="p-2">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  {tarifas.map((tarifa) => {
                    const tipo = tiposVehiculo.find(
                      (tv) => tv.id === tarifa.id_tipo_vehiculo
                    );
                    return (
                      <tr key={tarifa.id} className="text-center">
                        <td className="p-2">
                          {tipo ? tipo.descripcion : tarifa.id_tipo_vehiculo}
                        </td>
                        <td className="p-2">{tarifa.precio_base}</td>
                        <td className="p-2">{tarifa.precio_dia}</td>
                        <td className="p-2">{tarifa.precio_lavado ?? "-"}</td>
                        <td className="p-2 flex justify-center gap-2">
                          <button
                            className="bg-blue-500 text-white px-3 py-1 rounded"
                            onClick={() => handleEdit(tarifa)}
                          >
                            Editar
                          </button>
                          <button
                            className="bg-red-500 text-white px-3 py-1 rounded"
                            onClick={() => handleDelete(tarifa.id)}
                          >
                            Eliminar
                          </button>
                        </td>
                      </tr>
                    );
                  })}
                  {tarifas.length === 0 && (
                    <tr>
                      <td
                        colSpan="5"
                        className="text-center py-4 text-gray-500"
                      >
                        No hay tarifas registradas.
                      </td>
                    </tr>
                  )}
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Tarifas;
