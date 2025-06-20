<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;

Route::prefix("cliente")->middleware('jwt.cookie')->group(function () {
    Route::post("/", [ClienteController::class, "save"]);
    Route::post("/addrange", [ClienteController::class, "AddRange"]);

    Route::get("/relac/get", [ClienteController::class, "GetWithVehiculo"]); // ← ruta especializada
    Route::get("/", [ClienteController::class, "GetPaginate"]);
    Route::get("/{id}", [ClienteController::class, "GetById"]);

    Route::delete("/{id}", [ClienteController::class, "Delete"]);
    Route::delete("/", [ClienteController::class, "DeleteRange"]);

    Route::put("/{id}", [ClienteController::class, "Update"]);
});


