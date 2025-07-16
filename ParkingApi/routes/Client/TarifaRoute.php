<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TarifaController;

Route::prefix("tarifa")->middleware('jwt.cookie')->group(function () {
    // Crear
    Route::post("/", [TarifaController::class, "save"]);
    Route::post("/addrange", [TarifaController::class, "AddRange"]);

    // Lectura
    Route::get("/", [TarifaController::class, "GetPaginate"]);
    Route::get("/{id}", [TarifaController::class, "GetById"]);

    // Eliminación
    Route::delete("/", [TarifaController::class, "DeleteRange"]);
    Route::delete("/{id}", [TarifaController::class, "Delete"]);

    // Actualización
    Route::put("/{id}", [TarifaController::class, "Update"]);
});

// ✅ Ruta pública para usar en el frontend sin autenticación
Route::get('/tarifa-all', [TarifaController::class, 'GetAll']);




