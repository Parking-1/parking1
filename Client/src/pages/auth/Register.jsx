import { useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import InputWithIcon from "../../components/InputWithIcon";
import SelectWithIcon from "../../components/SelectWithIcon"; // al inicio del archivo
import {
  RiMailLine,
  RiLockLine,
  RiUser2Line,
  RiAdminLine,
} from "react-icons/ri";
import Axios from "axios";
import { toast } from "react-toastify";

const Register = () => {
  const navigate = useNavigate();
  const [showPassword, setShowPassword] = useState(false);
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [confirmPassword, setConfirmPassword] = useState("");
  const [passwordStrength, setPasswordStrength] = useState("");
  const [passwordMatch, setPasswordMatch] = useState(true);
  const [idCargo, setIdCargo] = useState(1); // Valor por defecto

  const handleShowPassword = () => {
    setShowPassword(!showPassword);
  };

  const handlePasswordChange = (e) => {
    const newPassword = e.target.value;
    setPassword(newPassword);
    evaluatePasswordStrength(newPassword);
    setPasswordMatch(newPassword === confirmPassword);
  };

  const handleConfirmPasswordChange = (e) => {
    const newConfirmPassword = e.target.value;
    setConfirmPassword(newConfirmPassword);
    setPasswordMatch(password === newConfirmPassword);
  };

  const evaluatePasswordStrength = (password) => {
    let strength = "Débil";
    const regexLowercase = /[a-z]/;
    const regexUppercase = /[A-Z]/;
    const regexNumber = /[0-9]/;
    const regexSpecialChar = /[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]/;

    if (
      password.length >= 8 &&
      regexLowercase.test(password) &&
      regexUppercase.test(password) &&
      regexNumber.test(password) &&
      regexSpecialChar.test(password)
    ) {
      strength = "Fuerte";
    } else if (password.length >= 8) {
      strength = "Moderada";
    }

    setPasswordStrength(strength);
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    if ([name, email, password, confirmPassword].includes("")) {
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
    if (![1, 2].includes(idCargo)) {
      toast.error("Cargo inválido", { theme: "dark" });
      return;
    }

    try {
      const response = await Axios.post(
        "http://localhost:8020/api/user/register",
        {
          name,
          email,
          password,
          password_confirmation: confirmPassword,
          id_cargo: idCargo,
        }
      );

      toast.success("Registro exitoso", { theme: "dark" });
      navigate("/");
    } catch (error) {
      console.error("Error al registrar:", error);

      if (error.response && error.response.data.email) {
        toast.error("El correo ya está registrado", { theme: "dark" });
      } else {
        toast.error("Error al registrar. Por favor, inténtalo de nuevo.", {
          theme: "dark",
        });
      }
    }
  };

  return (
    <div className="min-h-screen flex items-center justify-center p-4">
      <div className="bg-white p-8 rounded-lg w-full md:w-[500px]">
        <div className="mb-10">
          <h1 className="text-3xl uppercase font-bold text-center">
            Registrarse
          </h1>
        </div>
        <form onSubmit={handleSubmit} className="flex flex-col gap-4">
          <InputWithIcon
            icon={RiUser2Line}
            placeholder="Nombre(s)"
            value={name}
            onChange={(e) => setName(e.target.value)}
          />
          <InputWithIcon
            icon={RiMailLine}
            type="email"
            placeholder="Correo electrónico"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
          />
          <InputWithIcon
            icon={RiLockLine}
            placeholder="Crear contraseña"
            value={password}
            showToggle={true}
            showPassword={showPassword}
            onTogglePassword={handleShowPassword}
            onChange={handlePasswordChange}
          />
          <InputWithIcon
            icon={RiLockLine}
            placeholder="Confirmar contraseña"
            value={confirmPassword}
            showToggle={true}
            showPassword={showPassword}
            onTogglePassword={handleShowPassword}
            onChange={handleConfirmPasswordChange}
          />
          {!passwordMatch && (
            <p className="text-red-500 text-xs mt-1">
              Las contraseñas no coinciden
            </p>
          )}
          <SelectWithIcon
            icon={RiAdminLine}
            value={idCargo}
            onChange={(e) => setIdCargo(parseInt(e.target.value))}
            options={[
              { value: 1, label: "Empleado" },
              { value: 2, label: "Administrador" },
            ]}
          />
          <div>
            <button
              type="submit"
              disabled={!passwordMatch}
              className={`w-full py-2 px-4 rounded-lg text-sm font-medium transition-all ${
                passwordMatch
                  ? "bg-sky-600 text-white hover:bg-sky-700"
                  : "bg-gray-400 text-white cursor-not-allowed"
              }`}
            >
              Crear cuenta
            </button>

            <div
              className={`text-xs mt-1 ${
                passwordStrength === "Fuerte"
                  ? "text-green-600"
                  : passwordStrength === "Moderada"
                  ? "text-yellow-600"
                  : "text-red-600"
              }`}
            >
              Fortaleza de la contraseña: {passwordStrength}
            </div>
          </div>
        </form>
        <div className="flex items-center justify-between mt-4">
          <div>
            ¿Ya tienes una cuenta?{" "}
            <Link
              to="/"
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
              ¿Olvidaste tu contraseña?
            </Link>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Register;
