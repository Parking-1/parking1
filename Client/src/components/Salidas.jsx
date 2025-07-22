import { useState, useRef } from "react";
import axios from "../config/axios-instance.jsx";
import ResumenParqueadero from "./ResumenParqueadero.jsx";
import Navbar from "./Navbar";
import Sidebar from "./Sidebar";
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import dayjs from "dayjs";
import duration from "dayjs/plugin/duration";
dayjs.extend(duration);

const Salidas = () => {
  const resumenRef = useRef(); // 👉 Referencia al resumen
  const [placaBuscar, setPlacaBuscar] = useState("");
  const [ticket, setTicket] = useState("");
  const [lavado, setLavado] = useState(false);
  const [transaccion, setTransaccion] = useState(null);
  const [error, setError] = useState("");

  const buscarTransaccion = async () => {
    if (!placaBuscar) {
      toast.warning("🔍 Ingresa una placa para buscar");
      return;
    }

    try {
      const res = await axios.get(
        `/transaccion/placa/${placaBuscar.trim().toUpperCase()}`,
        {
          withCredentials: true,
        }
      );
      setTransaccion(res.data.data);
      setLavado(res.data.data.lavado); // Cargar si ya había
      setError("");
    } catch (error) {
      if (error.response?.status === 404) {
        toast.info(
          "ℹ️ No hay transacción activa para esa placa (ya pudo haber salido)"
        );
      } else {
        toast.error("❌ Error inesperado al buscar transacción");
      }
      setTransaccion(null);
      setError("❌ No se encontró una transacción activa para esta placa.");
    }
  };

  const buscarPorTicket = async () => {
    try {
      const res = await axios.get(`/transaccion/${ticket}`, {
        withCredentials: true,
      });
      setTransaccion(res.data.data);
      setLavado(res.data.data.lavado);
      setError("");
    } catch {
      setTransaccion(null);
      setError("❌ No se encontró transacción con ese número de ticket.");
    }
  };

  const cerrarTransaccion = async () => {
    try {
      const res = await axios.put(
        `/transaccion/${transaccion.id}/salida`,
        { lavado },
        {
          withCredentials: true,
        }
      );

      const nuevaTransaccion = res.data.transaccion;
      setTransaccion(nuevaTransaccion);

      toast.success("✅ Salida registrada correctamente");

      // 👇 Abrir e imprimir el PDF automáticamente
      if (nuevaTransaccion.pdf) {
        const printWindow = window.open(
          `/storage/${nuevaTransaccion.pdf}`,
          "_blank"
        );
        if (printWindow) {
          printWindow.onload = () => {
            printWindow.focus();
            printWindow.print();
          };
        } else {
          toast.warning(
            "⚠️ No se pudo abrir el PDF para imprimir. Verifica el navegador."
          );
        }
        resumenRef.current?.refetch();
      }

      // Limpiar placa si deseas buscar otra
      setPlacaBuscar("");
      setTicket("");
      setTransaccion(null);
      setLavado(false);
      setError("");
    } catch (error) {
      console.error(error);
      toast.error("❌ Error al cerrar la transacción");
    }
  };

  const calcularTiempo = () => {
    if (!transaccion?.fecha_entrada || !transaccion?.fecha_salida) return "";

    const entrada = dayjs(transaccion.fecha_entrada);
    const salida = dayjs(transaccion.fecha_salida || dayjs());
    const duracion = dayjs.duration(salida.diff(entrada));
    const horas = duracion.hours();
    const minutos = duracion.minutes();

    return `${horas}h ${minutos}min`;
  };

  return (
    <div>
      <Navbar />
      <div className="flex">
        <Sidebar />
        <div className="flex flex-col justify-center items-center mx-auto my-12 w-full">
          <ResumenParqueadero ref={resumenRef} />
          <div className="flex flex-col md:flex-row w-full max-w-5xl p-4">
            {/* Columna de búsqueda */}
            <div className="md:w-1/3 pr-4">
              <form
                onSubmit={(e) => {
                  e.preventDefault();
                  buscarTransaccion();
                }}
                className="flex flex-col space-y-4"
              >
                <label htmlFor="placa">Buscar por placa</label>
                <input
                  id="placa"
                  type="text"
                  value={placaBuscar}
                  onChange={(e) => setPlacaBuscar(e.target.value.toUpperCase())}
                  className="w-full py-2 px-4 border rounded uppercase"
                  placeholder="Ej. ABC123"
                />
                <button
                  type="submit"
                  className="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600"
                >
                  Buscar por placa
                </button>
              </form>

              <form
                onSubmit={(e) => {
                  e.preventDefault();
                  buscarPorTicket();
                }}
                className="flex flex-col space-y-4 mt-6"
              >
                <label htmlFor="ticket">Buscar por Nro de ticket</label>
                <input
                  id="ticket"
                  type="text"
                  value={ticket}
                  onChange={(e) => setTicket(e.target.value)}
                  className="w-full py-2 px-4 border rounded"
                  placeholder="Ej. 123"
                />
                <button
                  type="submit"
                  className="bg-purple-500 text-white py-2 px-4 rounded hover:bg-purple-600"
                >
                  Buscar por Ticket
                </button>
              </form>
            </div>

            {/* Columna de detalles */}
            {transaccion && (
              <div className="md:w-2/3 p-4 border rounded ml-0 md:ml-8 mt-6 md:mt-0 bg-gray-50">
                <div className="grid grid-cols-2 gap-4">
                  <div>
                    <strong>Placa:</strong> {transaccion.vehiculo.placa}
                  </div>
                  <div>
                    <strong>Hora de Entrada:</strong>{" "}
                    {dayjs(transaccion.fecha_entrada).format("HH:mm")}
                  </div>
                  <div>
                    <strong>Fecha de Entrada:</strong>{" "}
                    {dayjs(transaccion.fecha_entrada).format("DD/MM/YYYY")}
                  </div>
                  <div>
                    <strong>Hora de Salida:</strong> {dayjs().format("HH:mm")}
                  </div>
                  <div>
                    <strong>Fecha de Salida:</strong>{" "}
                    {dayjs().format("DD/MM/YYYY")}
                  </div>
                  <div>
                    <strong>Clase de Vehículo:</strong>{" "}
                    {transaccion.vehiculo?.tipo_vehiculo?.descripcion ?? "N/A"}
                  </div>
                  <div>
                    <strong>Cobro por Lavado:</strong>{" "}
                    {lavado
                      ? `$${transaccion.tarifa?.precio_lavado ?? "N/A"}`
                      : "$0"}
                  </div>
                  <div>
                    <strong>Tiempo Transcurrido:</strong> {calcularTiempo()}
                  </div>
                  <div className="col-span-2">
                    <label className="flex items-center space-x-2">
                      <input
                        type="checkbox"
                        checked={lavado}
                        onChange={() => setLavado(!lavado)}
                      />
                      <span>¿Aplicar cobro por lavado?</span>
                    </label>
                  </div>
                  <div className="col-span-2 font-bold">
                    Total a Pagar:{" "}
                    {transaccion.precio_total
                      ? `$${transaccion.precio_total}`
                      : "Pendiente de cierre"}
                  </div>
                </div>

                <div className="flex justify-center mt-6">
                  <button
                    onClick={cerrarTransaccion}
                    className="bg-green-500 text-white font-bold py-2 px-6 rounded hover:bg-green-600 transition"
                  >
                    Confirmar Salida y Pagar
                  </button>
                </div>
              </div>
            )}
          </div>
        </div>
      </div>
      <ToastContainer />
    </div>
  );
};

export default Salidas;
