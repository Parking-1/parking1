import { useState } from "react";
import axios from "axios";
import Navbar from "./Navbar";
import Sidebar from "./Sidebar";
import { toast, ToastContainer } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

const Reportes = () => {
  const [tipoReporte, setTipoReporte] = useState("");
  const [fechaInicio, setFechaInicio] = useState("");
  const [fechaFinal, setFechaFinal] = useState("");
  const [resultados, setResultados] = useState([]);

  const handleClick = async (tipo) => {
    if (!fechaInicio || !fechaFinal) {
      toast.warn("⚠️ Por favor selecciona ambas fechas.");
      return;
    }

    try {
      const res = await axios.post("/api/reportes", {
        tipo,
        fecha_inicio: fechaInicio,
        fecha_final: fechaFinal,
      });

      setTipoReporte(tipo);
      setResultados(res.data.data);
    } catch (error) {
      console.error("Error generando reporte:", error);
      toast.error("❌ Ocurrió un error al generar el reporte.");
    }
  };

  const renderTabla = () => {
    if (resultados.length === 0)
      return <p className="text-center mt-6">No hay resultados.</p>;

    switch (tipoReporte) {
      case "tickets":
        return (
          <table className="w-full border mt-6 text-sm">
            <thead className="bg-gray-200">
              <tr>
                <th className="border px-2">#</th>
                <th className="border px-2">Placa</th>
                <th className="border px-2">Fecha Entrada</th>
                <th className="border px-2">Lavado</th>
              </tr>
            </thead>
            <tbody>
              {resultados.map((t, i) => (
                <tr key={t.id}>
                  <td className="border px-2">{i + 1}</td>
                  <td className="border px-2">{t.placa}</td>
                  <td className="border px-2">{t.fecha_entrada}</td>
                  <td className="border px-2">{t.lavado ? "Sí" : "No"}</td>
                </tr>
              ))}
            </tbody>
          </table>
        );

      case "salidas":
        return (
          <table className="w-full border mt-6 text-sm">
            <thead className="bg-gray-200">
              <tr>
                <th className="border px-2">#</th>
                <th className="border px-2">Placa</th>
                <th className="border px-2">Entrada</th>
                <th className="border px-2">Salida</th>
                <th className="border px-2">Total Pagado</th>
              </tr>
            </thead>
            <tbody>
              {resultados.map((s, i) => (
                <tr key={s.id}>
                  <td className="border px-2">{i + 1}</td>
                  <td className="border px-2">{s.placa}</td>
                  <td className="border px-2">{s.fecha_entrada}</td>
                  <td className="border px-2">{s.fecha_salida}</td>
                  <td className="border px-2">{s.total}</td>
                </tr>
              ))}
            </tbody>
          </table>
        );

      case "estacionados":
        return (
          <table className="w-full border mt-6 text-sm">
            <thead className="bg-gray-200">
              <tr>
                <th className="border px-2">#</th>
                <th className="border px-2">Placa</th>
                <th className="border px-2">Fecha Entrada</th>
              </tr>
            </thead>
            <tbody>
              {resultados.map((v, i) => (
                <tr key={v.id}>
                  <td className="border px-2">{i + 1}</td>
                  <td className="border px-2">{v.placa}</td>
                  <td className="border px-2">{v.fecha_entrada}</td>
                </tr>
              ))}
            </tbody>
          </table>
        );

      case "pagos":
        return (
          <table className="w-full border mt-6 text-sm">
            <thead className="bg-gray-200">
              <tr>
                <th className="border px-2">#</th>
                <th className="border px-2">Cliente</th>
                <th className="border px-2">Documento</th>
                <th className="border px-2">Placa</th>
                <th className="border px-2">Inicio</th>
                <th className="border px-2">Fin</th>
                <th className="border px-2">Total</th>
              </tr>
            </thead>
            <tbody>
              {resultados.map((p, i) => (
                <tr key={p.id}>
                  <td className="border px-2">{i + 1}</td>
                  <td className="border px-2">
                    {p.cliente?.nombre} {p.cliente?.apellido}
                  </td>
                  <td className="border px-2">{p.cliente?.cedula}</td>
                  <td className="border px-2">{p.vehiculo?.placa || "-"}</td>
                  <td className="border px-2">{p.fecha_inicio}</td>
                  <td className="border px-2">{p.fecha_fin || "-"}</td>
                  <td className="border px-2">{p.total}</td>
                </tr>
              ))}
            </tbody>
          </table>
        );

      default:
        return null;
    }
  };
  const handleExportarPDF = async () => {
    if (!fechaInicio || !fechaFinal || !tipoReporte) {
      toast.warning(
        "⚠️ Selecciona fechas y tipo de reporte antes de exportar."
      );
      return;
    }

    try {
      const res = await axios.post(
        "/api/reportes/pdf",
        {
          tipo: tipoReporte,
          fecha_inicio: fechaInicio,
          fecha_final: fechaFinal,
        },
        {
          responseType: "blob", // 👈 necesario para manejar archivos binarios
        }
      );

      // Crear un enlace para descargar el archivo
      const blob = new Blob([res.data], { type: "application/pdf" });
      const url = window.URL.createObjectURL(blob);
      const link = document.createElement("a");
      link.href = url;
      link.setAttribute("download", `reporte_${tipoReporte}.pdf`);
      document.body.appendChild(link);
      link.click();
      link.remove();
      window.URL.revokeObjectURL(url);
    } catch (error) {
      console.error("Error al exportar PDF:", error);
      toast.error("❌ Error al generar el PDF.");
    }
  };

  return (
    <div>
      <Navbar />
      <div className="flex">
        <Sidebar />
        <div className="flex flex-col w-full p-6">
          {/* Filtros por fecha */}
          <div className="flex flex-col md:flex-row justify-center space-y-4 md:space-y-0 md:space-x-4 mb-8 items-end mt-12">
            <div className="flex flex-col w-full md:w-1/3">
              <label
                htmlFor="fechaInicio"
                className="mb-1 text-center font-semibold"
              >
                Fecha de Inicio
              </label>
              <input
                id="fechaInicio"
                type="date"
                className="border p-2 rounded w-full"
                value={fechaInicio}
                onChange={(e) => setFechaInicio(e.target.value)}
              />
            </div>
            <div className="flex flex-col w-full md:w-1/3">
              <label
                htmlFor="fechaFinal"
                className="mb-1 text-center font-semibold"
              >
                Fecha Final
              </label>
              <input
                id="fechaFinal"
                type="date"
                className="border p-2 rounded w-full"
                value={fechaFinal}
                onChange={(e) => setFechaFinal(e.target.value)}
              />
            </div>
          </div>

          {/* Opciones de reporte */}
          <div className="flex justify-center mb-6">
            <div className="flex flex-col space-y-4 w-full md:w-1/3">
              {[
                { tipo: "tickets", texto: "Listar Tickets" },
                { tipo: "salidas", texto: "Salidas de Vehículos" },
                { tipo: "estacionados", texto: "Vehículos Estacionados" },
                { tipo: "pagos", texto: "Pagos de Abonados" },
              ].map((btn) => (
                <button
                  key={btn.tipo}
                  className="bg-blue-500 text-white py-3 px-6 rounded hover:bg-blue-600 transition"
                  onClick={() => handleClick(btn.tipo)}
                >
                  {btn.texto}
                </button>
              ))}
              {tipoReporte && (
                <div className="text-center mb-6">
                  <button
                    className="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700"
                    onClick={handleExportarPDF}
                  >
                    Exportar en PDF
                  </button>
                </div>
              )}
            </div>
          </div>

          {/* Tabla de resultados */}
          <div>{renderTabla()}</div>
        </div>
      </div>
    </div>
  );
};

export default Reportes;
