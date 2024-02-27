import { useState } from "react";
import { Link } from "react-router-dom";

import {
  RiMailLine,
  RiLockLine,
  RiEyeLine,
  RiEyeOffLine,
  RiUser2Line,
} from "react-icons/ri";
import Axios from "axios"; // Importa Axios
import { toast } from "react-toastify";

const Register = () => {
  const [showPassword, setShowPassword] = useState(false);
  const [name, setName] = useState("");
  const [lastname, setLastname] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [confirmPassword, setConfirmPassword] = useState("");
  const [passwordStrength, setPasswordStrength] = useState("");
  const [passwordMatch, setPasswordMatch] = useState(true);

  const handleShowPassword = () => {
    setShowPassword(!showPassword);
  };

  const handleNameChange = (e) => {
    setName(e.target.value);
  };

  const handleLastnameChange = (e) => {
    setLastname(e.target.value);
  };

  const handleEmailChange = (e) => {
    setEmail(e.target.value);
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
    // Evaluar la fortaleza de la contraseña aquí
    // Puedes implementar tus propios criterios para determinar la fortaleza
    let strength = "Débil";

    // Se define una expresión regular para cada criterio
    const regexLowercase = /[a-z]/;
    const regexUppercase = /[A-Z]/;
    const regexNumber = /[0-9]/;
    const regexSpecialChar = /[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]/;

    if (password.length >= 8) {
      strength = "Moderada";
    } else if (
      regexLowercase.test(password) &&
      regexUppercase.test(password) &&
      regexNumber.test(password) &&
      regexSpecialChar.test(password)
    ) {
      // Si la contraseña cumple con todos los criterios, se considera 'Fuerte'
      strength = "Fuerte";
    }
    setPasswordStrength(strength);
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    if ([name, lastname, email, password, confirmPassword].includes("")) {
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
    //Validar que el email no exista en la base de datos
    try {
      // Realiza la solicitud POST al backend
      const response = await Axios.post("/api/register", {
        name,
        lastname,
        email,
        password,
      });

      // Maneja la respuesta del backend
      console.log("Registro exitoso:", response.data);
      toast.success("Registro exitoso", { theme: "dark" });

      // Redirige al usuario a otra página, como la página de inicio de sesión
      // history.push("/login");
    } catch (error) {
      // Maneja los errores de la solicitud
      console.error("Error al registrar:", error);
      toast.error("Error al registrar. Por favor, inténtalo de nuevo.", {
        theme: "dark",
      });
    }
  };

  // Enviar email de verificacion
  return (
    <div className="bg-white p-8 rounded-lg w-full md:w-[500px]">
      <div className="mb-10">
        <h1 className="text-3xl uppercase font-bold text-center">
          Registrarse
        </h1>
      </div>
      <form onSubmit={handleSubmit} className="flex flex-col gap-4">
        <div className="relative">
          <RiUser2Line className="absolute left-2 top-1/2 -translate-y-1/2 text-gray-500" />
          <input
            type="text"
            className="w-full border-gray-200 outline-none py-2 px-8 rounded-lg"
            placeholder="Nombre(s)"
            value={name}
            onChange={handleNameChange}
          />
        </div>
        <div className="relative">
          <RiUser2Line className="absolute left-2 top-1/2 -translate-y-1/2 text-gray-500" />
          <input
            type="text"
            className="w-full border-gray-200 outline-none py-2 px-8 rounded-lg"
            placeholder="Apellidos"
            value={lastname}
            onChange={handleLastnameChange}
          />
        </div>
        <div className="relative">
          <RiMailLine className="absolute left-2 top-1/2 -translate-y-1/2 text-gray-500" />
          <input
            type="email"
            className="w-full border-gray-200 outline-none py-2 px-8 rounded-lg"
            placeholder="correo-electronico"
            value={email}
            onChange={handleEmailChange}
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
            placeholder="confirmar-contraseña"
            value={confirmPassword}
            onChange={handlePasswordChange}
          />
          {!passwordMatch && (
            <p className="text-red-500 text-xs mt-1">
              Las contraseñas no coinciden
            </p>
          )}
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
            value={confirmPassword}
            onChange={handleConfirmPasswordChange}
          />
          {!passwordMatch && <p>Las contraseñas no coinciden</p>}
          <button disabled={!passwordMatch} onClick={handleSubmit}>
            Registrarse
          </button>
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
        <div className="text-xs text-gray-500">
          Fortaleza de la contraseña: {passwordStrength}
        </div>
        <div>
          <button className="mt-6 bg-sky-600 text-white w-full py-2 px-6 rounded-lg hover:scale-105 transition-all">
            Crear cuenta
          </button>
        </div>
      </form>
      <div className="flex items-center justify-between">
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
            ¿Olvidaste tu password?{" "}
          </Link>
        </div>
      </div>
    </div>
  );
};

export default Register;
