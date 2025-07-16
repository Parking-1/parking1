import { useState } from "react";
import { Link } from "react-router-dom";
import { RiMailLine } from "react-icons/ri";
import { toast } from "react-toastify";

const ForgetPassword = () => {
  const [email, setEmail] = useState("");

  const handleSubmit = async (e) => {
    e.preventDefault();

    // Validación vacíos
    if (email.trim() === "") {
      toast.error("El email es obligatorio", { theme: "dark" });
      return;
    }

    // Validación formato de email
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
      toast.error("Ingresa un correo electrónico válido", { theme: "dark" });
      return;
    }

    try {
      const response = await fetch(
        "http://localhost:8080/api/auth/forgot-password",
        {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ email }),
        }
      );

      const data = await response.json();

      if (!response.ok) {
        throw new Error(data.message || "Error al enviar el email");
      }

      toast.success("Se han enviado las instrucciones a tu correo", {
        theme: "dark",
      });
    } catch (error) {
      console.error("Error:", error);
      toast.error(error.message || "Error en la solicitud", { theme: "dark" });
    }
  };

  return (
    <div className="min-h-screen flex items-center justify-center p-4">
      <div className="bg-white p-8 rounded-lg w-full md:w-96">
        <div className="mb-10">
          <h1 className="text-3xl uppercase font-bold text-center">
            Recuperar contraseña
          </h1>
        </div>
        <form onSubmit={handleSubmit} className="flex flex-col gap-4 mb-6">
          <div className="relative">
            <RiMailLine className="absolute left-2 top-1/2 -translate-y-1/2 text-gray-500" />
            <input
              type="email"
              className="w-full border border-gray-300 py-2 px-8 rounded-lg outline-none"
              placeholder="correo-electronico"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
            />
          </div>
          <div>
            <button
              type="submit"
              className="mt-6 bg-sky-600 text-white w-full py-2 px-6 rounded-lg hover:scale-105 transition-all"
            >
              Enviar instrucciones
            </button>
          </div>
        </form>
        <div className="flex items-center justify-between text-sm">
          <div>
            ¿Ya tienes una cuenta?{" "}
            <Link to="/" className="text-sky-600 font-medium hover:underline">
              Inicia sesión
            </Link>
          </div>
          <div className="text-right">
            <Link
              to="/register"
              className="text-sky-600 font-medium hover:underline"
            >
              ¿No tienes una cuenta?
            </Link>
          </div>
        </div>
      </div>
    </div>
  );
};

export default ForgetPassword;
