<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CargoController;

Route::prefix("cargo")->group(function () {
    // Crear un nuevo cargo
    Route::post("/", [CargoController::class, "save"]);

    // Crear múltiples cargos
    Route::post("/add-range", [CargoController::class, "AddRange"]);

    // Obtener todos los cargos paginados
    Route::get("/", [CargoController::class, "GetPaginate"]);

    // Obtener un cargo por ID
    Route::get("/{id}", [CargoController::class, "GetById"]);

    // Actualizar un cargo
    Route::put("/{id}", [CargoController::class, "Update"]);

    // Eliminar un cargo por ID
    Route::delete("/{id}", [CargoController::class, "Delete"]);

    // Eliminar múltiples cargos
    Route::delete("/delete-range", [CargoController::class, "DeleteRange"]);
});

