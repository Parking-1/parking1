import { useState } from "react";
import { useParams, useNavigate } from "react-router-dom";
import {
  //RiMailLine,
  RiLockLine,
  RiEyeLine,
  RiEyeOffLine,
} from "react-icons/ri";
import { toast } from "react-toastify";

const ChangePassword = () => {
  const [showPassword, setShowPassword] = useState(false);
  const [password, setPassword] = useState("");
  const [confirmPassword, setConfirmPassword] = useState("");

  const navigate = useNavigate();

  const { token } = useParams();
  console.log(token);
  if (token !== "1") {
    navigate("/");
  }

  const handleShowPassword = () => {
    setShowPassword(!showPassword);
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    if (password.trim() === "" || confirmPassword.trim() === "") {
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

    if (password !== confirmPassword) {
      toast.error("Los passwords no son iguales", {
        theme: "dark",
      });
      return;
    }

    try {
      const response = await fetch(
        "URL_DEL_ENDPOINT_PARA_CAMBIAR_LA_CONTRASEÑA",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ password }),
        }
      );

      if (!response.ok) {
        throw new Error("No se pudo cambiar la contraseña");
      }

      toast.success("Tu contraseña se cambió correctamente", {
        theme: "dark",
      });
    } catch (error) {
      console.error("Error al cambiar la contraseña:", error);
      toast.error("Ocurrió un error al cambiar la contraseña", {
        theme: "dark",
      });
    }
  };

  return (
    <div className="min-h-screen flex items-center justify-center p-4">
      <div className="bg-white p-8 rounded-lg w-full md:w-96">
        <div className="mb-10">
          <h1 className="text-3xl uppercase font-bold text-center">
            Actualizar contraseña
          </h1>
        </div>
        <form onSubmit={handleSubmit} className="flex flex-col gap-4 mb-6">
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
              placeholder="contraseña"
              value={confirmPassword}
              onChange={(e) => setConfirmPassword(e.target.value)}
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
          {/* <div className="text-right">
          <Link
            to="olvide-pasword"
            className="text-gray-500 hover:text-sky-600 hover:underline transition-colors"
          >
            ¿Olvidaste tu password?
          </Link>
        </div> */}
          <div>
            <button className="mt-6 bg-sky-600 text-white w-full py-2 px-6 rounded-lg hover:scale-105 transition-all">
              Restablecer contraseña
            </button>
          </div>
        </form>
        {/* <div className="text-center">
        ¿No tienes una cuenta?{" "}
        <Link
          to="register"
          className="text-sky-600 font-medium hover:underline transition-all"
        >
          Registrate
        </Link>
      </div> */}
      </div>
    </div>
  );
};

export default ChangePassword;
