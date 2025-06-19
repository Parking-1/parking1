import { useState, useEffect } from "react";
import { useParams, useNavigate } from "react-router-dom";
import { RiLockLine, RiEyeLine, RiEyeOffLine } from "react-icons/ri";
import { toast } from "react-toastify";

const ChangePassword = () => {
  const [showPassword, setShowPassword] = useState(false);
  const [password, setPassword] = useState("");
  const [confirmPassword, setConfirmPassword] = useState("");
  const navigate = useNavigate();
  const { token } = useParams();

  // Redirección si el token no es válido (esto es solo temporal para pruebas)
  useEffect(() => {
    if (!token || token !== "1") {
      navigate("/");
    }
  }, [token, navigate]);

  const handleShowPassword = () => {
    setShowPassword(!showPassword);
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    if (password.trim() === "" || confirmPassword.trim() === "") {
      toast.error("Todos los campos son obligatorios", { theme: "dark" });
      return;
    }

    if (password.length < 6) {
      toast.error("La contraseña debe tener al menos 6 caracteres", {
        theme: "dark",
      });
      return;
    }

    if (password !== confirmPassword) {
      toast.error("Las contraseñas no coinciden", { theme: "dark" });
      return;
    }

    try {
      const response = await fetch(
        "http://localhost:8080/api/auth/change-password",
        {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ password, token }),
        }
      );

      if (!response.ok) {
        throw new Error("No se pudo cambiar la contraseña");
      }

      toast.success("Tu contraseña se cambió correctamente", { theme: "dark" });

      // Redirecciona al login luego de 2 segundos
      setTimeout(() => {
        navigate("/login");
      }, 2000);
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
        <h1 className="text-3xl uppercase font-bold text-center mb-10">
          Actualizar contraseña
        </h1>
        <form onSubmit={handleSubmit} className="flex flex-col gap-4 mb-6">
          <div className="relative">
            <RiLockLine className="absolute left-2 top-1/2 -translate-y-1/2 text-gray-500" />
            <input
              type={showPassword ? "text" : "password"}
              className="w-full border-gray-200 outline-none py-2 px-8 rounded-lg"
              placeholder="Nueva contraseña"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
            />
            {showPassword ? (
              <RiEyeOffLine
                onClick={handleShowPassword}
                className="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 cursor-pointer"
              />
            ) : (
              <RiEyeLine
                onClick={handleShowPassword}
                className="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 cursor-pointer"
              />
            )}
          </div>
          <div className="relative">
            <RiLockLine className="absolute left-2 top-1/2 -translate-y-1/2 text-gray-500" />
            <input
              type={showPassword ? "text" : "password"}
              className="w-full border-gray-200 outline-none py-2 px-8 rounded-lg"
              placeholder="Confirmar contraseña"
              value={confirmPassword}
              onChange={(e) => setConfirmPassword(e.target.value)}
            />
            {showPassword ? (
              <RiEyeOffLine
                onClick={handleShowPassword}
                className="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 cursor-pointer"
              />
            ) : (
              <RiEyeLine
                onClick={handleShowPassword}
                className="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 cursor-pointer"
              />
            )}
          </div>
          <button
            type="submit"
            className="mt-6 bg-sky-600 text-white w-full py-2 px-6 rounded-lg hover:scale-105 transition-all"
          >
            Restablecer contraseña
          </button>
        </form>
      </div>
    </div>
  );
};

export default ChangePassword;
