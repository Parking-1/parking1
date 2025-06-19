<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TipoVehiculoController;

Route::prefix("tipovehiculo")->group(function () {
    // Crear uno o varios
    Route::post("/", [TipoVehiculoController::class, "store"]);
    Route::post("/addrange", [TipoVehiculoController::class, "AddRange"]);

    // Lectura
    Route::get("/", [TipoVehiculoController::class, "GetPaginate"]);
    Route::get("/{id}", [TipoVehiculoController::class, "GetById"]);

    // Eliminación
    Route::delete("/{id}", [TipoVehiculoController::class, "Delete"]);
    Route::delete("/", [TipoVehiculoController::class, "DeleteRange"]);

    // Actualización
    Route::put("/{id}", [TipoVehiculoController::class, "Update"]);
});


