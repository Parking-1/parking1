<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CargoController;

Route::prefix("cargo")->middleware('jwt.cookie')->group(function () {
    // Crear
    Route::post("/", [CargoController::class, "Save"]);
    Route::post("/addrange", [CargoController::class, "AddRange"]);

    // Lectura
    Route::get("/", [CargoController::class, "GetPaginate"]);
    Route::get("/{id}", [CargoController::class, "GetById"]);

    // Eliminación
    Route::delete("/{id}", [CargoController::class, "Delete"]);
    Route::delete("/", [CargoController::class, "DeleteRange"]);

    // Actualización
    Route::put("/{id}", [CargoController::class, "Update"]);
});
