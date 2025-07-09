<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\TipoVehiculoController;
use App\Http\Controllers\TarifaController;
use App\Http\Controllers\TransaccionController;
use App\Http\Controllers\UserController;

// Rutas de vehículos
Route::prefix("vehiculo")->middleware('jwt.cookie')->group(function () {
    Route::post("/", [VehiculoController::class, "save"]);
    Route::post("/addrange", [VehiculoController::class, "AddRange"]);

    Route::get("/with-cliente", [VehiculoController::class, "GetWithCliente"]);
    Route::get("/grouped", [VehiculoController::class, "GetGroupVehiculos"]);
    Route::get("/report", [VehiculoController::class, "GetReport"]);

    Route::get("/", [VehiculoController::class, "GetPaginate"]);
    Route::get("/{id}", [VehiculoController::class, "GetById"]);

    Route::delete("/{id}", [VehiculoController::class, "Delete"]);
    Route::delete("/", [VehiculoController::class, "DeleteRange"]);

    Route::put("/{id}", [VehiculoController::class, "Update"]);
});

// ✅ Ruta independiente para buscar vehículo por placa
Route::get('/vehiculo/by-placa', [VehiculoController::class, 'GetByPlaca'])->middleware('jwt.cookie');

// ✅ Ruta independiente para buscar transacción activa por placa
Route::get('/transaccion/placa/{placa}', [TransaccionController::class, 'GetByPlaca'])->middleware('jwt.cookie');

// Rutas para tipos de vehículos y tarifas
Route::get('/tipos-vehiculo', [TipoVehiculoController::class, 'GetAll']);
Route::get('/tarifa-all', [TarifaController::class, 'GetAll']);

Route::middleware(['jwt.cookie', 'is.admin'])->group(function () {
    Route::post('/tarifa-all', [TarifaController::class, 'Save']);
    Route::put('/tarifa-all/{id}', [TarifaController::class, 'Update']);
    Route::delete('/tarifa-all/{id}', [TarifaController::class, 'Delete']);
});

// Rutas de transacciones
Route::prefix("transaccion")->middleware('jwt.cookie')->group(function () {
    Route::post("/", [TransaccionController::class, "Save"]);
    Route::put("/{id}/cerrar", [TransaccionController::class, "CerrarTransaccion"]);

    Route::get("/", [TransaccionController::class, "GetPaginate"]);
    Route::get("/{id}", [TransaccionController::class, "GetById"]);
    Route::get("/between/fechas", [TransaccionController::class, "GetBetween"]);

    Route::put("/{id}", [TransaccionController::class, "Update"]);
    Route::delete("/{id}", [TransaccionController::class, "Delete"]);
    Route::delete("/", [TransaccionController::class, "DeleteRange"]);
});

// Autenticación de usuarios
Route::post('/user/authenticate', [UserController::class, 'authenticate']);
Route::post('/user/register', [UserController::class, 'register']);

Route::post('/vehiculo/first-or-create', [VehiculoController::class, 'firstOrCreateByPlaca']);

//Route::get('/cargo', [CargoController::class, 'index']);


