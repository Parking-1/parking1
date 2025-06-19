<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehiculoController;

Route::prefix("vehiculo")->group(function () {

    // Crear vehículos
    Route::post("/", [VehiculoController::class, "save"]);
    Route::post("/addrange", [VehiculoController::class, "AddRange"]);

    // Lectura especializada (rutas específicas deben ir antes de /{id})
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

