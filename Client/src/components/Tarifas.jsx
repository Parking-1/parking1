import React, { useState, useEffect } from "react";
import axios from "axios";
import Navbar from "./Navbar";
import Sidebar from "./Sidebar";

const Tarifas = () => {
  const url = "http://localhost:8080/api/tarifa";
  const [tarifas, setTarifas] = useState([]);
  const [formValues, setFormValues] = useState({
    claseVehiculo: "",
    precioHora: "",
    precioDia: "",
    precioLavado: "",
  });

  useEffect(() => {
    getTarifas();
  }, []);

  const getTarifas = async () => {
    try {
      const response = await axios.get(url);
      console.log(response.data.data);
      setTarifas(response.data.data || []);
    } catch (error) {
      console.error("Error fetching tarifas", error);
    }
  };

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormValues({ ...formValues, [name]: value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      const response = await axios.post(url, {
        id_tipo_vehiculo: formValues.claseVehiculo,
        tipo_tarifa: "hora", // Suponiendo que el tipo de tarifa sea "hora"
        precio_base: formValues.precioHora, // Puedes cambiar esto para usar los diferentes precios
      });
      setTarifas([...tarifas, response.data.data]);
    } catch (error) {
      console.error("Error saving tarifa", error);
    }
  };

  return (
    <div>
      <Navbar />
      <div className="flex">
        <Sidebar />
        <div className="flex flex-col justify-center items-center mx-auto my-30">
          <div className="flex">
            <div className="mr-40">
              <form
                className="flex flex-col items-center justify-center"
                onSubmit={handleSubmit}
              >
                <input
                  type="text"
                  name="claseVehiculo"
                  placeholder="Clase de Vehiculo"
                  className="mb-6 w-48 py-2 px-4"
                  value={formValues.claseVehiculo}
                  onChange={handleChange}
                />
                <input
                  type="text"
                  name="precioHora"
                  placeholder="Precio por Hora"
                  className="mb-6 w-48 py-2 px-4"
                  value={formValues.precioHora}
                  onChange={handleChange}
                />
                <input
                  type="text"
                  name="precioDia"
                  placeholder="Precio por Dia"
                  className="mb-6 w-48 py-2 px-4"
                  value={formValues.precioDia}
                  onChange={handleChange}
                />
                <input
                  type="text"
                  name="precioLavado"
                  placeholder="Precio por Lavado"
                  className="mb-6 w-48 py-2 px-4"
                  value={formValues.precioLavado}
                  onChange={handleChange}
                />
                <div className="flex flex-col gap-2">
                  <button
                    type="submit"
                    className="bg-green-500 text-white font-bold py-2 px-4 rounded-md mt-6 mb-2 w-48"
                  >
                    Agregar Tarifa
                  </button>
                  <button
                    type="button"
                    className="bg-blue-500 text-white font-bold py-2 px-4 rounded-md mt-2 mb-2 w-48"
                  >
                    Editar Tarifa
                  </button>
                </div>
              </form>
            </div>
            <div>
              <table className="border-solid bg-slate-50 w-100 h-80">
                <thead className="flex flex-row gap-6 text-white font-bold py-2 px-4 bg-blue-400 ">
                  <tr>
                    <th>Clase de Vehiculo</th>
                    <th>Precio por hora o fraccion</th>
                    <th>Precio por Dia</th>
                    <th>Precio Adicional</th>
                  </tr>
                </thead>
                <tbody>
                  {Array.isArray(tarifas) &&
                    tarifas.map((tarifa) => (
                      <tr key={tarifa.id}>
                        <td>{tarifa.id_tipo_vehiculo}</td>
                        <td>{tarifa.precio_base}</td>
                        <td>{tarifa.precio_dia}</td>
                        <td>{tarifa.precio_lavado}</td>
                        <td>
                          <button
                            onClick={() => handleEdit(tarifa)}
                            className="bg-blue-500 text-white font-bold py-2 px-4 rounded-md mt-2 mb-2"
                          >
                            Editar
                          </button>
                          <button
                            onClick={() => handleDelete(tarifa.id)}
                            className="bg-red-500 text-white font-bold py-2 px-4 rounded-md mt-2 mb-2"
                          >
                            Eliminar
                          </button>
                        </td>
                      </tr>
                    ))}
                </tbody>
              </table>
              <div className="flex items-center justify-center">
                <button className="bg-red-500 text-white font-bold py-2 px-4 rounded-md mt-6 w-48">
                  Eliminar
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Tarifas;
