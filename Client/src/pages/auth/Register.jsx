import { useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import InputWithIcon from "../../components/InputWithIcon";
import SelectWithIcon from "../../components/SelectWithIcon";
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

  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [emailExists, setEmailExists] = useState(false);
  const [password, setPassword] = useState("");
  const [confirmPassword, setConfirmPassword] = useState("");
  const [idCargo, setIdCargo] = useState(1);
  const [showPassword, setShowPassword] = useState(false);
  const [passwordStrength, setPasswordStrength] = useState("");
  const [passwordMatch, setPasswordMatch] = useState(true);
  const [isLoading, setIsLoading] = useState(false);

  const handleShowPassword = () => setShowPassword(!showPassword);

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
    const hasLower = /[a-z]/.test(password);
    const hasUpper = /[A-Z]/.test(password);
    const hasNumber = /[0-9]/.test(password);
    const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);

    if (
      password.length >= 8 &&
      hasLower &&
      hasUpper &&
      hasNumber &&
      hasSpecial
    ) {
      strength = "Fuerte";
    } else if (password.length >= 8) {
      strength = "Moderada";
    }

    setPasswordStrength(strength);
  };

  const checkEmailExists = async () => {
    if (!email) return;
    try {
      const res = await Axios.post(
        "http://localhost:8020/api/user/email-exists",
        { email }
      );
      setEmailExists(res.data.exists);
    } catch (error) {
      console.error("Error verificando email:", error);
      setEmailExists(false);
    }
  };

  const isFormValid = () => {
    return (
      name.trim() !== "" &&
      email.trim() !== "" &&
      password.length >= 6 &&
      password === confirmPassword &&
      !emailExists
    );
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    if (!isFormValid()) {
      toast.error("Completa todos los campos correctamente", { theme: "dark" });
      return;
    }

    try {
      setIsLoading(true);
      const res = await Axios.post("http://localhost:8020/api/user/register", {
        name,
        email,
        password,
        password_confirmation: confirmPassword,
        id_cargo: idCargo,
      });

      const token = res.data.token;
      localStorage.setItem("token", token);
      toast.success("Registro exitoso. Bienvenido!", { theme: "dark" });
      navigate("/home");
    } catch (error) {
      console.error("Error al registrar:", error);
      toast.error("Error al registrar. Intenta de nuevo.", { theme: "dark" });
    } finally {
      setIsLoading(false);
    }
  };

  return (
    <div className="min-h-screen flex items-center justify-center p-4">
      <div className="bg-white p-8 rounded-lg w-full md:w-[500px]">
        <h1 className="text-3xl uppercase font-bold text-center mb-10">
          Registrarse
        </h1>
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
            onBlur={checkEmailExists}
          />
          {emailExists && (
            <p className="text-red-500 text-xs -mt-2">
              Este correo ya está registrado
            </p>
          )}
          <InputWithIcon
            icon={RiLockLine}
            placeholder="Crear contraseña"
            value={password}
            showToggle
            showPassword={showPassword}
            onTogglePassword={handleShowPassword}
            onChange={handlePasswordChange}
          />
          <InputWithIcon
            icon={RiLockLine}
            placeholder="Confirmar contraseña"
            value={confirmPassword}
            showToggle
            showPassword={showPassword}
            onTogglePassword={handleShowPassword}
            onChange={handleConfirmPasswordChange}
          />
          {!passwordMatch && (
            <p className="text-red-500 text-xs -mt-2">
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
          <button
            type="submit"
            disabled={!isFormValid() || isLoading}
            className={`w-full py-2 px-4 rounded-lg text-sm font-medium transition-all ${
              isFormValid() && !isLoading
                ? "bg-sky-600 text-white hover:bg-sky-700"
                : "bg-gray-400 text-white cursor-not-allowed"
            }`}
          >
            {isLoading ? "Registrando..." : "Crear cuenta"}
          </button>
          <p
            className={`text-xs mt-1 ${
              passwordStrength === "Fuerte"
                ? "text-green-600"
                : passwordStrength === "Moderada"
                ? "text-yellow-600"
                : "text-red-600"
            }`}
          >
            Fortaleza de la contraseña: {passwordStrength}
          </p>
        </form>

        <div className="flex items-center justify-between mt-4 text-sm">
          <span>
            ¿Ya tienes una cuenta?{" "}
            <Link to="/" className="text-sky-600 hover:underline">
              Ingresa
            </Link>
          </span>
          <Link to="/forgetpassword" className="text-sky-600 hover:underline">
            ¿Olvidaste tu contraseña?
          </Link>
        </div>
      </div>
    </div>
  );
};

export default Register;
