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

  const handleShowPassword = () => {
    setShowPassword(!showPassword);
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      const response = await Axios.post(
        "http://localhost:8000/api/user/login",
        { email, password }
      );
      const token = response.data.token;
      localStorage.setItem("token", token);
      console.log(localStorage.getItem("token"));
      // Redirige al usuario a la página principal u otra página después del inicio de sesión
      navigate("/home");
    } catch (error) {
      // Muestra un mensaje de error al usuario si la autenticación falla
      toast.error("Credenciales incorrectas. Por favor, inténtalo de nuevo.", {
        theme: "dark",
      });
      console.error("Error al iniciar sesión:", error);
    }
  };

  return (
    <div className="min-h-screen flex items-center justify-center p-4">
      <div className="bg-white p-8 rounded-lg w-full md:w-96">
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
              className="w-full border-gray-200 outline-none py-2 px-8 rounded-lg"
              placeholder="Correo Electrónico"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
            />
          </div>
          <div className="relative">
            <RiLockLine className="absolute left-2 top-1/2 -translate-y-1/2 text-gray-500" />
            <input
              type={showPassword ? "text" : "password"}
              className="w-full border-gray-200 outline-none py-2 px-8 rounded-lg"
              placeholder="Contraseña"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
            />
            {showPassword ? (
              <RiEyeOffLine
                onClick={handleShowPassword}
                className="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 hover:cursor-pointer"
              />
            ) : (
              <RiEyeLine
                onClick={handleShowPassword}
                className="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 hover:cursor-pointer"
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
            <button className="mt-6 bg-sky-600 text-white w-full py-2 px-6 rounded-lg hover:scale-105 transition-all">
              Ingresar
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
