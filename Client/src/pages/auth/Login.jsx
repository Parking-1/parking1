import { useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import {
  RiMailLine,
  RiLockLine,
  RiEyeLine,
  RiEyeOffLine,
} from "react-icons/ri";
import Axios from "axios";
import { toast } from "react-toastify";

const Login = () => {
  const navigate = useNavigate();
  const [showPassword, setShowPassword] = useState(false);
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [isLoading, setIsLoading] = useState(false);

  const handleShowPassword = () => setShowPassword(!showPassword);

  const handleSubmit = async (e) => {
    e.preventDefault();

    if (!email || !password) {
      toast.error("Por favor, completa todos los campos.", { theme: "dark" });
      return;
    }

    setIsLoading(true);
    try {
      const response = await Axios.post(
        "http://localhost:8000/api/user/login",
        { email, password }
      );
      const token = response.data.token;
      localStorage.setItem("token", token);
      navigate("/home");
    } catch (error) {
      const message =
        error?.response?.status === 401
          ? "Credenciales incorrectas. Por favor, inténtalo de nuevo."
          : error?.request
          ? "No se pudo conectar al servidor. Revisa tu conexión."
          : "Ocurrió un error inesperado. Inténtalo de nuevo.";

      toast.error(message, { theme: "dark" });
      console.error("Error al iniciar sesión:", error);
    } finally {
      setIsLoading(false);
    }
  };

  return (
    <div className="min-h-screen flex items-center justify-center p-4">
      <div className="bg-white p-8 rounded-lg w-full md:w-96 shadow-md">
        <div className="mb-10">
          <h1 className="text-3xl uppercase font-bold text-center">
            Iniciar Sesión
          </h1>
        </div>
        <form onSubmit={handleSubmit} className="flex flex-col gap-4 mb-6">
          <div className="relative">
            <RiMailLine className="absolute left-2 top-1/2 -translate-y-1/2 text-gray-500" />
            <input
              type="email"
              className="w-full border border-gray-200 outline-none py-2 px-8 rounded-lg"
              placeholder="Correo Electrónico"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              aria-label="Correo Electrónico"
            />
          </div>
          <div className="relative">
            <RiLockLine className="absolute left-2 top-1/2 -translate-y-1/2 text-gray-500" />
            <input
              type={showPassword ? "text" : "password"}
              className="w-full border border-gray-200 outline-none py-2 px-8 rounded-lg"
              placeholder="Contraseña"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              aria-label="Contraseña"
            />
            {showPassword ? (
              <RiEyeOffLine
                aria-label="Ocultar contraseña"
                onClick={handleShowPassword}
                className="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 cursor-pointer"
              />
            ) : (
              <RiEyeLine
                aria-label="Mostrar contraseña"
                onClick={handleShowPassword}
                className="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 cursor-pointer"
              />
            )}
          </div>
          <div className="text-right">
            <Link
              to="/forgetpassword"
              className="text-gray-500 hover:text-sky-600 hover:underline transition-colors"
            >
              ¿Olvidaste tu contraseña?
            </Link>
          </div>
          <div>
            <button
              disabled={isLoading}
              className={`mt-6 w-full py-2 px-6 rounded-lg ${
                isLoading
                  ? "bg-gray-400 cursor-not-allowed"
                  : "bg-sky-600 text-white hover:scale-105 transition-all"
              }`}
            >
              {isLoading ? "Ingresando..." : "Ingresar"}
            </button>
          </div>
        </form>
        <div className="text-center">
          ¿No tienes una cuenta?{" "}
          <Link
            to="/register"
            className="text-sky-600 font-medium hover:underline transition-all"
          >
            Regístrate
          </Link>
        </div>
      </div>
    </div>
  );
};

export default Login;
