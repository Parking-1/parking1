<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransaccionController;

Route::prefix("transaccion")->middleware('jwt.cookie')->group(function () {

    // Crear una o varias transacciones
    Route::post("/", [TransaccionController::class, "save"]);
    Route::post("/addrange", [TransaccionController::class, "AddRange"]);

    // Lectura de transacciones
    Route::get("/", [TransaccionController::class, "GetPaginate"]);
    Route::get("/between/vehiculo", [TransaccionController::class, "GetBetween"]);
    Route::get("/{id}", [TransaccionController::class, "GetById"]);

    // Eliminación
    Route::delete("/{id}", [TransaccionController::class, "Delete"]);
    Route::delete("/", [TransaccionController::class, "DeleteRange"]);

    // Actualización
    Route::put("/{id}", [TransaccionController::class, "Update"]);
});



