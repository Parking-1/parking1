<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehiculoController;

Route::middleware(['api'])->prefix("vehiculo")->group(function () {

    Route::post("/", [VehiculoController::class, "save"]);
    Route::post("/addrange", [VehiculoController::class, "AddRange"]);

    Route::get("/", [VehiculoController::class, "GetPaginate"]);
    Route::get("/{id}", [VehiculoController::class, "GetById"]);
    Route::get("/relac/get", [VehiculoController::class, "GetWithCliente"]);

    Route::delete("/{id}", [VehiculoController::class, "Delete"]);
    Route::delete("/", [VehiculoController::class, "DeleteRange"]);

    Route::put("/{id}", [VehiculoController::class, "Update"]);
});

