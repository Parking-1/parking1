import React from "react";
import PropTypes from "prop-types";

const tiposVehiculo = [
  { id: 1, nombre: "Moto" },
  { id: 2, nombre: "Carro" },
  { id: 3, nombre: "Camión" },
  { id: 4, nombre: "Autobús" },
  { id: 5, nombre: "Vehículo Sin Determinar" },
];

const SelectorTipoVehiculo = ({ tipoSeleccionado, setTipoSeleccionado }) => {
  return (
    <div className="mb-4">
      <label
        htmlFor="tipoVehiculo"
        className="block text-sm font-medium text-gray-700"
      >
        Tipo de Vehículo
      </label>
      <select
        id="tipoVehiculo"
        name="tipoVehiculo"
        value={tipoSeleccionado}
        onChange={(e) => setTipoSeleccionado(Number(e.target.value))}
        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
        required
      >
        <option value="">Seleccione un tipo</option>
        {tiposVehiculo.map((tipo) => (
          <option key={tipo.id} value={tipo.id}>
            {tipo.nombre}
          </option>
        ))}
      </select>
    </div>
  );
};

SelectorTipoVehiculo.propTypes = {
  tipoSeleccionado: PropTypes.oneOfType([PropTypes.string, PropTypes.number])
    .isRequired,
  setTipoSeleccionado: PropTypes.func.isRequired,
};

export default SelectorTipoVehiculo;
