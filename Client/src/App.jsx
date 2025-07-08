import { BrowserRouter, Routes, Route } from "react-router-dom";
import { ToastContainer } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

import Login from "./pages/auth/Login";
import Register from "./pages/auth/Register";
import ForgetPassword from "./pages/auth/ForgetPassword";
import ChangePassword from "./pages/auth/ChangePassword";
import Home from "./pages/auth/Home";
import Tarifas from "./components/Tarifas";
import Ingresos from "./components/Ingresos";
import Salidas from "./components/Salidas";
import Abonados from "./components/Abonados";
import Caja from "./components/Caja";
import Usuarios from "./components/Usuarios";
import Reportes from "./components/Reportes";
import Pagos from "./components/Pagos";
import Error404 from "./pages/404"; // Mover al final de imports para coherencia

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Login />} />
        <Route path="/register" element={<Register />} />
        <Route path="/forgetpassword" element={<ForgetPassword />} />
        <Route path="/changepassword/:id" element={<ChangePassword />} />
        <Route path="/home" element={<Home />} />
        <Route path="/tarifas" element={<Tarifas />} />
        <Route path="/ingresos" element={<Ingresos />} />
        <Route path="/salidas" element={<Salidas />} />
        <Route path="/abonados" element={<Abonados />} />
        <Route path="/caja" element={<Caja />} />
        <Route path="/pagos" element={<Pagos />} />
        <Route path="/reportes" element={<Reportes />} />
        <Route path="/usuarios" element={<Usuarios />} />
        <Route path="*" element={<Error404 />} />
      </Routes>

      {/* Toast Container visible en toda la app */}
      <ToastContainer
        position="top-right"
        autoClose={3000}
        hideProgressBar={false}
        newestOnTop={false}
        closeOnClick
        pauseOnFocusLoss
        draggable
        pauseOnHover
        theme="colored"
      />
    </BrowserRouter>
  );
}

export default App;
