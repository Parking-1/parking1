import { useState, useEffect } from "react";
import axios from "../config/axios-instance.jsx";

import Navbar from "./Navbar";
import Sidebar from "./Sidebar";

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
    }
  };

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormValues({ ...formValues, [name]: value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    const { claseVehiculo, precioHora, precioDia, precioLavado } = formValues;

    if (
      [precioHora, precioDia, precioLavado].some((v) => isNaN(v) || v === "") ||
      claseVehiculo === ""
    ) {
      alert("Completa todos los campos correctamente.");
      return;
    }

    setLoading(true);

    try {
      if (editingId) {
        const response = await axios.put(`${url}/${editingId}`, {
          id_tipo_vehiculo: claseVehiculo,
          precio_base: precioHora,
          precio_dia: precioDia,
          precio_lavado: precioLavado,
        });
        setTarifas(
          tarifas.map((t) => (t.id === editingId ? response.data.data : t))
        );
        setEditingId(null);
      } else {
        const response = await axios.post(url, {
          id_tipo_vehiculo: claseVehiculo,
          tipo_tarifa: "hora",
          precio_base: precioHora,
          precio_dia: precioDia,
          precio_lavado: precioLavado,
        });
        await fetchTarifas(); // ⚠️ Asegúrate de volver a traer la lista completa desde el backend
      }

      setFormValues({
        claseVehiculo: "",
        precioHora: "",
        precioDia: "",
        precioLavado: "",
      });
    } catch (error) {
      console.error("Error al guardar la tarifa", error);
    }

    setLoading(false);
  };

  const handleEdit = (tarifa) => {
    setFormValues({
      claseVehiculo: tarifa.id_tipo_vehiculo,
      precioHora: tarifa.precio_base,
      precioDia: tarifa.precio_dia,
      precioLavado: tarifa.precio_lavado,
    });
    setEditingId(tarifa.id);
  };

  const handleDelete = async (id) => {
    try {
      await axios.delete(`${url}/${id}`);
      setTarifas(tarifas.filter((t) => t.id !== id));
    } catch (error) {
      console.error("Error al eliminar la tarifa", error);
    }
  };

  return (
    <div>
      <Navbar />
      <div className="flex">
        <Sidebar />
        <div className="flex flex-col justify-center items-center mx-auto my-12 w-full">
          <div className="flex flex-col md:flex-row w-full max-w-6xl p-6 gap-8">
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
                placeholder="Precio por Hora"
                className="w-full py-2 px-4 border rounded"
                value={formValues.precioHora}
                onChange={handleChange}
              />
              <input
                type="text"
                name="precioDia"
                placeholder="Precio por Día"
                className="w-full py-2 px-4 border rounded"
                value={formValues.precioDia}
                onChange={handleChange}
              />
              <input
                type="text"
                name="precioLavado"
                placeholder="Precio por Lavado"
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
                  ? "Actualizar Tarifa"
                  : loading
                  ? "Guardando..."
                  : "Agregar Tarifa"}
              </button>
            </form>

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
                        <td className="p-2">{tarifa.precio_lavado}</td>
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
