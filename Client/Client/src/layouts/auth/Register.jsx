import { useState } from "react";
import { Link } from "react-router-dom";
import {
  RiMailLine,
  RiLockLine,
  RiEyeLine,
  RiEyeOffLine,
  RiUser2Line,
} from "react-icons/ri";
import { toast } from "react-toastify";

const Register = () => {
  const [showPassword, setShowPassword] = useState(false);
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");

  const handleShowPassword = () => {
    setShowPassword(!showPassword);
  };

  const handleSubmit = (e) => {
    e.preventDefault();

    if ([email, password].includes("")) {
      toast.error("Todos los campos son obligatorios", {
        theme: "dark",
      });
      return;
    }
    if (password.length < 6) {
      toast.error("El password debe contener al menos 6 caracteres", {
        theme: "dark",
      });
      return;
    }
    console.log("Toda la funcionalidad de login");
  };
  return (
    <div className="bg-white p-8 rounded-lg m-full md:w-96">
      <div className="mb-10">
        <h1 className="text-3xl uppercase font-bold">Registrarse</h1>
      </div>
      <form onSubmit={handleSubmit} className="flex flex-col gap-4">
        <div className="relative">
          <RiUser2Line className="absolute left-2 top-1/2 -translate-y-1/2 text-gray-500" />
          <input
            type="text"
            className="w-full border-gray-200 outline-none py-2 px-8 rounded-lg"
            placeholder="Nombre(s)"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
          />
        </div>
        <div className="relative">
          <RiUser2Line className="absolute left-2 top-1/2 -translate-y-1/2 text-gray-500" />
          <input
            type="text"
            className="w-full border-gray-200 outline-none py-2 px-8 rounded-lg"
            placeholder="Apellidos"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
          />
        </div>
        <div className="relative">
          <RiMailLine className="absolute left-2 top-1/2 -translate-y-1/2 text-gray-500" />
          <input
            type="email"
            className="w-full border-gray-200 outline-none py-2 px-8 rounded-lg"
            placeholder="correo-electronico"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
          />
        </div>
        {/* <div className="relative">
          <RiMailLine className="absolute left-2 top-1/2 -translate-y-1/2 text-gray-500" />
          <input
            type="email"
            className="w-full border-gray-200 outline-none py-2 px-8 rounded-lg"
            placeholder="correo-electronico"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
          />
        </div> */}
        <div className="relative">
          <RiLockLine className="absolute left-2 top-1/2 -translate-y-1/2 text-gray-500" />
          <input
            type={showPassword ? "text" : "password"}
            className="w-full border-gray-200 outline-none py-2 px-8 rounded-lg"
            placeholder="contraseña"
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
        <div className="relative">
          <RiLockLine className="absolute left-2 top-1/2 -translate-y-1/2 text-gray-500" />
          <input
            type={showPassword ? "text" : "password"}
            className="w-full border-gray-200 outline-none py-2 px-8 rounded-lg"
            placeholder="confirmar-contraseña"
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
        <div>
          <button className="mt-6 bg-sky-600 text-white w-full py-2 px-6 rounded-lg hover:scale-105 transition-all">
            Ingresar
          </button>
        </div>
      </form>
      <div className="flex items-center justify-between">
        <div>
          ¿Ya tienes una cuenta?{" "}
          <Link
            to="/register"
            className="text-sky-600 font-medium hover:underline transition-all"
          >
            Ingresa
          </Link>
        </div>
        <div className="text-right">
          <Link
            to="/forgetpassword"
            className="text-sky-600 font-medium hover:underline transition-all"
          >
            ¿Olvidaste tu password?{" "}
          </Link>
        </div>
      </div>
    </div>
  );
};

export default Register;
