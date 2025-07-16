# 🚗 Sistema de Parqueadero - Parking1

Sistema completo de gestión de parqueaderos, desarrollado con Laravel y React. Administra ingresos y salidas de vehículos, tarifas, planes de abonado, pagos y reportes.

## 🧱 Tecnologías utilizadas

- **Backend:** Laravel 10 (PHP 8.2)
- **Frontend:** React + Vite
- **Autenticación:** JWT + Cookies HTTP-only
- **Base de Datos:** MySQL / MariaDB
- **Reportes:** Generación en PDF
- **Roles de Usuario:** Administrador y Empleado

## ⚙️ Instalación

### Backend (Laravel)

cd ParkingApi
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve

### Frontend (React)

cd Client
npm install
npm run dev


## 🔐 Variables de entorno

Asegúrate de configurar correctamente los archivos .env para:

Laravel (BD, JWT_SECRET, etc.)

React (VITE_API_BASE_URL si usas variables para endpoint del backend)


## 📊 Funcionalidades principales

-Registro de ingresos y salidas de vehículos
-Gestión de clientes y vehículos
-Tarifas por tipo de vehículo
-Planes de abonado y pagos
-Reportes filtrables (tickets, salidas, estacionados, pagos)
-Exportación en PDF
-Control de acceso con roles

## 🗃️ Estructura del Proyecto

parking1/
│
├── Client/           # Frontend (React)
├── ParkingApi/       # Backend (Laravel)
├── .gitignore
├── README.md
└── ...

## 🧑‍💻 Autor
Desarrollado por Edison Céspedes




### 📄 `LICENSE` (MIT)

MIT License

Copyright (c) 2025 Edison Cespedes

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND...
