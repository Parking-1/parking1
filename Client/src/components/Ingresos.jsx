import { useState } from "react";
import axios from "axios";
import Navbar from "./Navbar";
import Sidebar from "./Sidebar";

const Ingresos = () => {
  const [placa, setPlaca] = useState("");
  const [tipo, setTipo] = useState("auto");
  const [hora, setHora] = useState("");
  const [fecha, setFecha] = useState("");
  const [lavado, setLavado] = useState(false);

  const handleSubmit = async (e) => {
    e.preventDefault();

    if (!placa || !hora || !fecha || !tipo) {
      alert("Todos los campos son obligatorios.");
      return;
    }

    try {
      const response = await axios.post(
        "/api/transaccion",
        {
          placa,
          tipo_vehiculo: tipo,
          hora,
          fecha,
          lavado: lavado ? 1 : 0,
        },
        { withCredentials: true }
      );

      alert("Ingreso registrado correctamente");
      setPlaca("");
      setTipo("auto");
      setHora("");
      setFecha("");
      setLavado(false);
    } catch (error) {
      console.error("Error al registrar ingreso:", error);
      alert("Ocurrió un error al registrar el ingreso.");
    }
  };

  return (
    <div>
      <Navbar />
      <div className="flex">
        <Sidebar />
        <div className="flex flex-col items-center mx-auto mt-10 w-full max-w-xl">
          <form
            onSubmit={handleSubmit}
            className="w-full p-6 bg-white rounded-lg shadow"
          >
            <h1 className="text-xl font-semibold mb-4 text-center">
              Registrar Ingreso de Vehículo
            </h1>

            {/* Placa */}
            <label htmlFor="placa" className="block mb-2 font-medium">
              Ingrese placa o matrícula del vehículo
            </label>
            <input
              id="placa"
              name="placa"
              value={placa}
              onChange={(e) => setPlaca(e.target.value.toUpperCase())}
              className="w-full h-12 px-4 py-2 rounded-lg border border-gray-300 text-xl uppercase mb-4"
              type="text"
              placeholder="Ej: ABC123"
              required
            />

            {/* Tipo de Vehículo */}
            <label htmlFor="tipo" className="block mb-2 font-medium">
              Seleccione clase de vehículo
            </label>
            <select
              id="tipo"
              name="tipo"
              value={tipo}
              onChange={(e) => setTipo(e.target.value)}
              className="w-full h-12 px-4 py-2 rounded-lg border border-gray-300 mb-4"
              required
            >
              <option value="auto">Auto</option>
              <option value="moto">Moto</option>
              <option value="camion">Camión</option>
              <option value="bus">Bus</option>
            </select>

            {/* Hora y Fecha */}
            <div className="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
              <div>
                <label htmlFor="hora" className="block mb-2 font-medium">
                  Hora
                </label>
                <input
                  id="hora"
                  name="hora"
                  value={hora}
                  onChange={(e) => setHora(e.target.value)}
                  type="time"
                  className="w-full h-12 px-4 py-2 rounded-lg border border-gray-300"
                  required
                />
              </div>
              <div>
                <label htmlFor="fecha" className="block mb-2 font-medium">
                  Fecha
                </label>
                <input
                  id="fecha"
                  name="fecha"
                  value={fecha}
                  onChange={(e) => setFecha(e.target.value)}
                  type="date"
                  className="w-full h-12 px-4 py-2 rounded-lg border border-gray-300"
                  required
                />
              </div>
            </div>

            {/* Lavado */}
            <div className="flex items-center mb-4">
              <input
                id="lavado"
                name="lavado"
                type="checkbox"
                checked={lavado}
                onChange={(e) => setLavado(e.target.checked)}
                className="mr-2"
              />
              <label htmlFor="lavado" className="font-medium">
                ¿Desea incluir lavado?
              </label>
            </div>

            {/* Botones */}
            <div className="flex flex-col items-center gap-4">
              <button
                type="submit"
                className="bg-green-500 text-white font-bold py-2 px-4 rounded-md w-full"
              >
                Ingresar
              </button>
              <button
                type="button"
                className="text-blue-500 hover:underline"
                onClick={() => {
                  setPlaca("");
                  setTipo("auto");
                  setHora("");
                  setFecha("");
                  setLavado(false);
                }}
              >
                ¿Desea borrar el ingreso?
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  );
};

export default Ingresos;
