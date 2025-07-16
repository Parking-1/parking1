import { useState, useEffect } from "react";
import axios from "axios";
import Navbar from "./Navbar";
import Sidebar from "./Sidebar";

const Caja = () => {
  const [caja, setCaja] = useState({
    ingreso_monto: "",
    ingreso_motivo: "",
    egreso_monto: "",
    egreso_motivo: "",
  });

  const [movimientos, setMovimientos] = useState([]);

  const handleChange = (e) => {
    setCaja({ ...caja, [e.target.name]: e.target.value });
  };

  const obtenerMovimientos = async () => {
    try {
      const res = await axios.get("/api/caja");
      setMovimientos(res.data.data);
    } catch (error) {
      console.error("Error al obtener movimientos", error);
    }
  };

  const agregarIngreso = async () => {
    if (!caja.ingreso_monto || !caja.ingreso_motivo) return;
    try {
      await axios.post("/api/caja", {
        tipo: "ingreso",
        monto: caja.ingreso_monto,
        motivo: caja.ingreso_motivo,
      });
      setCaja({ ...caja, ingreso_monto: "", ingreso_motivo: "" });
      obtenerMovimientos();
    } catch (error) {
      console.error("Error al registrar ingreso", error);
    }
  };

  const agregarEgreso = async () => {
    if (!caja.egreso_monto || !caja.egreso_motivo) return;
    try {
      await axios.post("/api/caja", {
        tipo: "egreso",
        monto: caja.egreso_monto,
        motivo: caja.egreso_motivo,
      });
      setCaja({ ...caja, egreso_monto: "", egreso_motivo: "" });
      obtenerMovimientos();
    } catch (error) {
      console.error("Error al registrar egreso", error);
    }
  };

  useEffect(() => {
    obtenerMovimientos();
  }, []);

  const calcularTotal = () => {
    let total = 0;
    movimientos.forEach((m) => {
      total +=
        m.tipo === "ingreso" ? parseFloat(m.monto) : -parseFloat(m.monto);
    });
    return total.toFixed(2);
  };

  return (
    <div>
      <Navbar />
      <div className="flex">
        <Sidebar />
        <div className="m-auto w-full mt-10 p-6 max-w-screen-md">
          <h1 className="text-xl font-semibold mb-2">
            Efectivo Neto en Caja: $ {calcularTotal()}
          </h1>

          <form className="space-y-6">
            {/* Ingresos */}
            <div>
              <h2 className="text-lg font-bold border-b pb-2 mb-4">Ingresos</h2>
              <div className="flex flex-col md:flex-row gap-4 mb-2">
                <input
                  name="ingreso_monto"
                  value={caja.ingreso_monto}
                  onChange={handleChange}
                  placeholder="Monto"
                  type="number"
                  className="h-12 px-4 border rounded-md w-full"
                />
                <input
                  name="ingreso_motivo"
                  value={caja.ingreso_motivo}
                  onChange={handleChange}
                  placeholder="Motivo del Ingreso"
                  type="text"
                  className="h-12 px-4 border rounded-md w-full"
                />
                <button
                  type="button"
                  onClick={agregarIngreso}
                  className="bg-green-500 text-white font-bold py-2 px-4 rounded-md h-12"
                >
                  Agregar ingreso
                </button>
              </div>
            </div>

            {/* Egresos */}
            <div>
              <h2 className="text-lg font-bold border-b pb-2 mb-4">Egresos</h2>
              <div className="flex flex-col md:flex-row gap-4 mb-2">
                <input
                  name="egreso_monto"
                  value={caja.egreso_monto}
                  onChange={handleChange}
                  placeholder="Monto"
                  type="number"
                  className="h-12 px-4 border rounded-md w-full"
                />
                <input
                  name="egreso_motivo"
                  value={caja.egreso_motivo}
                  onChange={handleChange}
                  placeholder="Motivo del Retiro"
                  type="text"
                  className="h-12 px-4 border rounded-md w-full"
                />
                <button
                  type="button"
                  onClick={agregarEgreso}
                  className="bg-red-500 text-white font-bold py-2 px-4 rounded-md h-12"
                >
                  Registrar egreso
                </button>
              </div>
            </div>

            {/* Historial */}
            <div>
              <h2 className="text-lg font-bold border-b pb-2 mt-8 mb-4">
                Historial de Movimientos
              </h2>
              <table className="w-full border text-center">
                <thead className="bg-gray-200">
                  <tr>
                    <th>ID</th>
                    <th>Tipo</th>
                    <th>Monto</th>
                    <th>Motivo</th>
                    <th>Fecha</th>
                  </tr>
                </thead>
                <tbody>
                  {movimientos.map((mov) => (
                    <tr key={mov.id}>
                      <td>{mov.id}</td>
                      <td
                        className={
                          mov.tipo === "ingreso"
                            ? "text-green-600 font-bold"
                            : "text-red-600 font-bold"
                        }
                      >
                        {mov.tipo}
                      </td>
                      <td>$ {parseFloat(mov.monto).toFixed(2)}</td>
                      <td>{mov.motivo || "-"}</td>
                      <td>{mov.fecha}</td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          </form>
        </div>
      </div>
    </div>
  );
};

export default Caja;
