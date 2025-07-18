import { useEffect, useState } from "react";
import axios from "@/api/axios";

const ConfiguracionEmpresa = () => {
  const [form, setForm] = useState({
    nombre_empresa: "",
    nit: "",
    direccion: "",
    telefono: "",
    leyenda: "",
  });

  useEffect(() => {
    axios
      .get("/api/configuracion")
      .then((res) => setForm(res.data))
      .catch((err) => console.error(err));
  }, []);

  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    axios
      .put("/api/configuracion", form)
      .then(() => alert("Configuración actualizada"))
      .catch((err) => alert("Error al guardar"));
  };

  return (
    <form onSubmit={handleSubmit} className="space-y-4 p-4">
      <input
        name="nombre_empresa"
        value={form.nombre_empresa}
        onChange={handleChange}
        placeholder="Nombre de la empresa"
      />
      <input
        name="nit"
        value={form.nit}
        onChange={handleChange}
        placeholder="NIT"
      />
      <input
        name="direccion"
        value={form.direccion}
        onChange={handleChange}
        placeholder="Dirección"
      />
      <input
        name="telefono"
        value={form.telefono}
        onChange={handleChange}
        placeholder="Teléfono"
      />
      <textarea
        name="leyenda"
        value={form.leyenda}
        onChange={handleChange}
        placeholder="Leyenda legal (opcional)"
      />
      <button type="submit">Guardar</button>
    </form>
  );
};

export default ConfiguracionEmpresa;
