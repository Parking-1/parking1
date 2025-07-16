import React, { useState } from "react";
import axios from "axios";

const VehiculoForm = () => {
  const [placa, setPlaca] = useState("");
  const [idTipoVehiculo, setIdTipoVehiculo] = useState("");
  const [idCliente, setIdCliente] = useState("");
  const [mensaje, setMensaje] = useState(null);

  const handleSubmit = async (e) => {
    e.preventDefault();
    setMensaje(null);

    try {
      const response = await axios.post("/api/vehiculo/first-or-create", {
        placa,
        id_tipo_vehiculo: idTipoVehiculo,
        id_cliente: idCliente || null,
      });

      const { data, message } = response.data;
      setMensaje(`✔️ ${message} - ID: ${data.id}`);
    } catch (error) {
      if (error.response?.status === 422) {
        const errores = error.response.data.details;
        const errorMsg = Object.values(errores).flat().join(", ");
        setMensaje(`❌ Error de validación: ${errorMsg}`);
      } else {
        setMensaje(`❌ Error inesperado: ${error.message}`);
      }
    }
  };

  return (
    <form
      onSubmit={handleSubmit}
      className="space-y-4 p-4 border rounded shadow-md"
    >
      <h2 className="text-lg font-bold">Registrar Vehículo</h2>

      <div>
        <label>Placa:</label>
        <input
          type="text"
          value={placa}
          onChange={(e) => setPlaca(e.target.value.toUpperCase())}
          className="border p-2 w-full"
          required
        />
      </div>

      <div>
        <label>ID Tipo Vehículo:</label>
        <input
          type="number"
          value={idTipoVehiculo}
          onChange={(e) => setIdTipoVehiculo(e.target.value)}
          className="border p-2 w-full"
          required
        />
      </div>

      <div>
        <label>ID Cliente (opcional):</label>
        <input
          type="number"
          value={idCliente}
          onChange={(e) => setIdCliente(e.target.value)}
          className="border p-2 w-full"
        />
      </div>

      <button
        type="submit"
        className="bg-blue-500 text-white px-4 py-2 rounded"
      >
        Guardar Vehículo
      </button>

      {mensaje && (
        <div className="mt-4 p-2 border bg-gray-100 rounded text-sm">
          {mensaje}
        </div>
      )}
    </form>
  );
};

export default VehiculoForm;
