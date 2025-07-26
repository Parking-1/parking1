import { useState, useEffect } from "react";
import PropTypes from "prop-types";

function FormularioAbonado({
  tarifaDia = 10000,
  espaciosDisponibles,
  onRegistrar,
}) {
  const [dias, setDias] = useState(1);
  const [total, setTotal] = useState(tarifaDia);
  const [formData, setFormData] = useState({
    nombre: "",
    placa: "",
    documento: "",
    tipoVehiculo: 1, // 1: Moto por defecto
    // otros campos...
  });

  useEffect(() => {
    setTotal(dias * tarifaDia);
  }, [dias, tarifaDia]);

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData((prev) => ({ ...prev, [name]: value }));
  };

  const handleDiasChange = (e) => {
    const value = parseInt(e.target.value);
    setDias(value >= 1 ? value : 1);
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    if (espaciosDisponibles <= 0) {
      alert("⚠️ No hay espacios disponibles.");
      return;
    }

    // Enviar al backend
    onRegistrar({ ...formData, dias, total });
  };

  return (
    <form
      onSubmit={handleSubmit}
      className="space-y-4 border p-4 rounded-xl shadow-md"
    >
      <h2 className="text-xl font-bold">Nuevo Abonado</h2>

      <input
        name="nombre"
        placeholder="Nombre"
        onChange={handleChange}
        className="border p-2 w-full"
      />
      <input
        name="documento"
        placeholder="Documento"
        onChange={handleChange}
        className="border p-2 w-full"
      />
      <input
        name="placa"
        placeholder="Placa"
        onChange={handleChange}
        className="border p-2 w-full"
      />

      <label className="block text-sm font-medium mt-2">
        Duración (en días):
      </label>
      <input
        type="number"
        min={1}
        value={dias}
        onChange={handleDiasChange}
        className="border p-2 w-full"
      />

      <p className="text-green-700">
        💡 Pagar por días es más económico que por horas.
      </p>

      <p className="text-lg font-semibold">
        Total: <span className="text-blue-600">${total.toLocaleString()}</span>
      </p>

      {espaciosDisponibles <= 0 ? (
        <p className="text-red-600 font-semibold">
          ⚠️ No hay espacios disponibles
        </p>
      ) : (
        <button className="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
          Registrar Abonado
        </button>
      )}
    </form>
  );
}
FormularioAbonado.propTypes = {
  tarifaDia: PropTypes.number,
  espaciosDisponibles: PropTypes.number.isRequired,
  onRegistrar: PropTypes.func.isRequired,
};

export default FormularioAbonado;
