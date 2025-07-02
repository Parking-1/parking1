<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\TipoVehiculoController;
use App\Http\Controllers\TarifaController;
use App\Http\Controllers\TransaccionController;

//use App\Http\Controllers\CargoController;

Route::prefix("vehiculo")->middleware('jwt.cookie')->group(function () {

    // Crear vehículos
    Route::post("/", [VehiculoController::class, "save"]);
    Route::post("/addrange", [VehiculoController::class, "AddRange"]);

    // Lectura especializada
    Route::get("/with-cliente", [VehiculoController::class, "GetWithCliente"]);
    Route::get("/grouped", [VehiculoController::class, "GetGroupVehiculos"]);
    Route::get("/report", [VehiculoController::class, "GetReport"]);

    // Lectura general
    Route::get("/", [VehiculoController::class, "GetPaginate"]);
    Route::get("/{id}", [VehiculoController::class, "GetById"]);

    // Eliminación
    Route::delete("/{id}", [VehiculoController::class, "Delete"]);
    Route::delete("/", [VehiculoController::class, "DeleteRange"]);

    // Actualización
    Route::put("/{id}", [VehiculoController::class, "Update"]);
});

Route::get('/tipos-vehiculo', [TipoVehiculoController::class, 'GetAll']);
Route::get('/tarifa-all', [TarifaController::class, 'GetAll']);


Route::middleware(['jwt.cookie', 'is.admin'])->group(function () {
    //Route::post('/tarifa-all', [TarifaController::class, 'store']);
    Route::post('/tarifa-all', [TarifaController::class, 'Save']);
    Route::put('/tarifa-all/{id}', [TarifaController::class, 'Update']);
    Route::delete('/tarifa-all/{id}', [TarifaController::class, 'Delete']);
});

Route::prefix("transaccion")->middleware('jwt.cookie')->group(function () {

    // Registrar entrada
    Route::post("/", [TransaccionController::class, "Save"]);

    // Cerrar transacción (salida)
    Route::put("/{id}/cerrar", [TransaccionController::class, "CerrarTransaccion"]);

    // Consultar
    Route::get("/", [TransaccionController::class, "GetPaginate"]);
    Route::get("/{id}", [TransaccionController::class, "GetById"]);
    Route::get("/between/fechas", [TransaccionController::class, "GetBetween"]);

    // Actualizar o eliminar
    Route::put("/{id}", [TransaccionController::class, "Update"]);
    Route::delete("/{id}", [TransaccionController::class, "Delete"]);
    Route::delete("/", [TransaccionController::class, "DeleteRange"]);
});




//Route::get('/cargo', [CargoController::class, 'index']);

