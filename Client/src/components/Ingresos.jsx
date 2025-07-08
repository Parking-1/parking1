import { useState } from "react";
import axios from "../config/axios-instance.jsx";
import Navbar from "./Navbar";
import Sidebar from "./Sidebar";
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

const Ingresos = () => {
  const [placa, setPlaca] = useState("");
  const [tipo, setTipo] = useState("auto");
  const [hora, setHora] = useState("");
  const [fecha, setFecha] = useState("");
  const [lavado, setLavado] = useState(false);

  const tipoToId = (tipo) => {
    switch (tipo) {
      case "auto":
        return 1;
      case "moto":
        return 2;
      case "camion":
        return 3;
      case "bus":
        return 4;
      default:
        return 1;
    }
  };

  const crearVehiculo = async () => {
    try {
      const res = await axios.post(
        "/vehiculo",
        {
          placa,
          id_tipo_vehiculo: tipoToId(tipo),
          //id_cliente: null,
        },
        { withCredentials: true }
      );
      return res.data.data;
    } catch (error) {
      if (
        error.response &&
        error.response.data &&
        error.response.data.error === "Validación fallida"
      ) {
        const detalles = error.response.data.details;
        if (detalles && detalles.placa && detalles.placa.length > 0) {
          toast.error(`❌ ${detalles.placa[0]}`);
        } else {
          toast.error("❌ Validación fallida.");
        }
      } else if (
        error.response &&
        error.response.data &&
        error.response.data.error === "Token no encontrado"
      ) {
        toast.error(
          "❌ Tu sesión ha expirado. Por favor, inicia sesión nuevamente."
        );
        setTimeout(() => {
          window.location.href = "/login";
        }, 2000);
      } else {
        toast.error("❌ Error al crear el vehículo.");
      }
      return null;
    }
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    if (!placa || !hora || !fecha || !tipo) {
      toast.error("❗ Todos los campos son obligatorios.");
      return;
    }

    const vehiculo = await crearVehiculo();
    if (!vehiculo) return;

    try {
      await axios.post(
        "/transaccion",
        {
          id_vehiculo: vehiculo.id,
          lavado,
        },
        { withCredentials: true }
      );

      toast.success("✅ Ingreso registrado correctamente.");
      setPlaca("");
      setTipo("auto");
      setHora("");
      setFecha("");
      setLavado(false);
    } catch (error) {
      console.error("Error al registrar ingreso:", error);
      toast.error("❌ Ocurrió un error al registrar el ingreso.");
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
      <ToastContainer
        position="top-right"
        autoClose={3000}
        hideProgressBar={false}
        newestOnTop={false}
        closeOnClick
        pauseOnFocusLoss
        draggable
        pauseOnHover
        theme="colored"
      />
    </div>
  );
};

export default Ingresos;
