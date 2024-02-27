import { BrowserRouter, Routes, Route } from "react-router-dom";
import AuthLayout from "./layouts/auth/AuthLayout";
import Login from "./pages/auth/Login";
import Register from "./layouts/auth/Register";
import ForgetPassword from "./pages/auth/ForgetPassword";
import ChangePassword from "./pages/auth/ChangePassword";
import Error404 from "./pages/404";

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<AuthLayout />}>
          <Route index element={<Login />} />
          <Route path="register" element={<Register />} />
          <Route path="forgetpassword" element={<ForgetPassword />} />
          <Route path="changepassword/:id" element={<ChangePassword />} />
        </Route>
        <Route path="*" element={<Error404 />} />
      </Routes>
    </BrowserRouter>
  );
}

export default App;
