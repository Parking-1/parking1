import { useState, useEffect } from "react";
import axios from "axios";
import Navbar from "./Navbar";
import Sidebar from "./Sidebar";
import { toast } from "react-toastify";
import SelectorTipoVehiculo from "./SelectorTipoVehiculo"; // <- IMPORTANTE

const Abonados = () => {
  const [formData, setFormData] = useState({
    nombre: "",
    apellido: "",
    cedula: "",
    placa: "",
    telefono: "",
    monto: "",
    duracion: "",
    tipo_plan: "",
    fecha_inicio: "",
    fecha_fin: "",
    total: "",
  });

  const [tipoVehiculo, setTipoVehiculo] = useState(""); // <- NUEVO
  const [planes, setPlanes] = useState([]);
  const [modoEdicion, setModoEdicion] = useState(false);
  const [idPlanEditando, setIdPlanEditando] = useState(null);

  useEffect(() => {
    const monto = parseFloat(formData.monto);
    const duracion = parseInt(formData.duracion);

    if (!isNaN(monto) && !isNaN(duracion) && formData.fecha_inicio) {
      const fechaInicio = new Date(formData.fecha_inicio);
      const fechaFin = new Date(fechaInicio);
      fechaFin.setDate(fechaFin.getDate() + duracion);

      setFormData((prev) => ({
        ...prev,
        total: monto,
        fecha_fin: fechaFin.toISOString().split("T")[0],
      }));
    }
  }, [formData.monto, formData.duracion, formData.fecha_inicio]);

  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const buscarAbonado = async () => {
    try {
      let res = null;

      if (formData.placa) {
        res = await axios.get(`/api/cliente/by-placa/${formData.placa}`);
      } else if (formData.cedula) {
        res = await axios.get(`/api/cliente/by-documento/${formData.cedula}`);
      } else if (formData.nombre) {
        res = await axios.get(`/api/cliente/by-nombre-apellido`, {
          params: { nombre: formData.nombre },
        });
      } else {
        toast.error("Ingrese al menos un campo para buscar");
        return;
      }

      const cliente = res.data.datos || res.data.data;

      setFormData((prev) => ({
        ...prev,
        nombre: cliente.nombre || "",
        apellido: cliente.apellido || "",
        cedula: cliente.cedula || "",
        telefono: cliente.telefono || "",
        placa: cliente.vehiculo?.[0]?.placa || "",
      }));

      getPlanes(cliente.id);
    } catch (error) {
      console.error(error);
      toast.error("Abonado no encontrado");
    }
  };

  const getPlanes = async (clienteId) => {
    try {
      const res = await axios.get(`/api/planes-abonado/${clienteId}`);
      setPlanes(res.data.data || []);
    } catch (err) {
      console.error(err);
    }
  };

  const grabarPlan = async (e) => {
    e.preventDefault();

    try {
      if (!tipoVehiculo) {
        toast.error("Debe seleccionar el tipo de vehículo");
        return;
      }

      if (modoEdicion && idPlanEditando) {
        await axios.put(`/api/planes-abonado/${idPlanEditando}`, {
          ...formData,
          id_tipo_vehiculo: tipoVehiculo,
        });
        toast.success("Plan actualizado correctamente");
        setModoEdicion(false);
        setIdPlanEditando(null);
      } else {
        await axios.post("/api/cliente/abonado-plan", {
          ...formData,
          id_tipo_vehiculo: tipoVehiculo,
        });
        toast.success("Plan guardado correctamente");
      }

      buscarAbonado();
      resetFormulario();
    } catch (error) {
      console.error(error);
      toast.error(error.response?.data?.error || "Error al guardar el plan");
    }
  };

  const eliminarPlan = async (id) => {
    if (!window.confirm("¿Deseas eliminar este plan?")) return;

    try {
      await axios.delete(`/api/planes-abonado/${id}`);
      toast.info("Plan eliminado");
      setPlanes((prev) => prev.filter((plan) => plan.id !== id));
    } catch (err) {
      console.error(err);
      toast.error("Error al eliminar el plan");
    }
  };

  const editarPlan = (plan) => {
    setFormData({
      ...formData,
      tipo_plan: plan.tipo_plan,
      duracion: plan.duracion,
      monto: plan.monto,
      total: plan.total,
      fecha_inicio: plan.fecha_inicio,
      fecha_fin: plan.fecha_fin,
    });
    setTipoVehiculo(plan.id_tipo_vehiculo); // <- NUEVO
    setModoEdicion(true);
    setIdPlanEditando(plan.id);
  };

  const resetFormulario = () => {
    setFormData((prev) => ({
      ...prev,
      tipo_plan: "",
      duracion: "",
      monto: "",
      total: "",
      fecha_inicio: "",
      fecha_fin: "",
    }));
    setTipoVehiculo(""); // <- NUEVO
    setModoEdicion(false);
    setIdPlanEditando(null);
  };

  return (
    <div>
      <Navbar />
      <div className="flex flex-wrap">
        <Sidebar />
        <div className="m-auto w-full max-w-screen-lg p-4">
          <form className="space-y-6">
            <div className="grid grid-cols-4 gap-4">
              <input
                name="nombre"
                value={formData.nombre}
                onChange={handleChange}
                placeholder="Nombres"
              />
              <input
                name="apellido"
                value={formData.apellido}
                onChange={handleChange}
                placeholder="Apellido"
              />
              <input
                name="telefono"
                value={formData.telefono}
                onChange={handleChange}
                placeholder="Teléfono"
              />
              <input
                name="cedula"
                value={formData.cedula}
                onChange={handleChange}
                placeholder="Documento"
              />
              <input
                name="placa"
                value={formData.placa}
                onChange={handleChange}
                placeholder="Placa"
              />
              <button
                type="button"
                onClick={buscarAbonado}
                className="bg-green-500 text-white"
              >
                Buscar
              </button>
            </div>

            <div className="grid grid-cols-4 gap-4">
              <input
                name="monto"
                value={formData.monto}
                onChange={handleChange}
                placeholder="Monto"
              />
              <select
                name="duracion"
                value={formData.duracion}
                onChange={handleChange}
              >
                <option value="">Duración</option>
                <option value="15">15 días</option>
                <option value="30">30 días</option>
                <option value="60">60 días</option>
              </select>
              <select
                name="tipo_plan"
                value={formData.tipo_plan}
                onChange={handleChange}
              >
                <option value="">Tipo</option>
                <option value="semanal">Semanal</option>
                <option value="mensual">Mensual</option>
              </select>
              <input
                type="date"
                name="fecha_inicio"
                value={formData.fecha_inicio}
                onChange={handleChange}
              />
              <input
                type="date"
                name="fecha_fin"
                value={formData.fecha_fin}
                onChange={handleChange}
                min={formData.fecha_inicio}
              />

              <input
                name="total"
                value={formData.total}
                onChange={handleChange}
                placeholder="Total"
              />
            </div>

            <SelectorTipoVehiculo
              tipoSeleccionado={tipoVehiculo}
              setTipoSeleccionado={setTipoVehiculo}
            />

            <div className="text-right space-x-2">
              <button
                type="submit"
                onClick={grabarPlan}
                className="bg-blue-500 text-white px-4 py-2 rounded-md"
              >
                {modoEdicion ? "Actualizar Plan" : "Grabar Plan"}
              </button>
              {modoEdicion && (
                <button
                  onClick={resetFormulario}
                  type="button"
                  className="bg-gray-500 text-white px-4 py-2 rounded-md"
                >
                  Cancelar
                </button>
              )}
            </div>
          </form>

          {planes.length > 0 && (
            <div className="mt-8">
              <h2 className="font-bold text-lg mb-2">Planes del Abonado</h2>
              <table className="w-full border text-sm">
                <thead className="bg-gray-200">
                  <tr>
                    <th>#</th>
                    <th>Tipo</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Monto</th>
                    <th>Total</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  {planes.map((plan, i) => (
                    <tr key={plan.id}>
                      <td>{i + 1}</td>
                      <td>{plan.tipo_plan}</td>
                      <td>{plan.fecha_inicio}</td>
                      <td>{plan.fecha_fin}</td>
                      <td>${plan.monto}</td>
                      <td>${plan.total}</td>
                      <td className="space-x-2">
                        <button
                          onClick={() => editarPlan(plan)}
                          className="text-blue-500 hover:underline"
                        >
                          Editar
                        </button>
                        <button
                          onClick={() => eliminarPlan(plan.id)}
                          className="text-red-500 hover:underline"
                        >
                          Eliminar
                        </button>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          )}
        </div>
      </div>
    </div>
  );
};

export default Abonados;
