<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EspacioController;

Route::prefix("espacio")->middleware('jwt.cookie')->group(function () {
    Route::post("/", [EspacioController::class, "save"]);
    Route::post("/addrange", [EspacioController::class, "AddRange"]);

    Route::get("/estado/{estado}", [EspacioController::class, "GetEspacesBy"]); // Ruta especializada
    Route::get("/", [EspacioController::class, "GetPaginate"]);
    Route::get("/{id}", [EspacioController::class, "GetById"]);

    Route::delete("/{id}", [EspacioController::class, "Delete"]);
    Route::delete("/", [EspacioController::class, "DeleteRange"]);

    Route::put("/{id}", [EspacioController::class, "Update"]);
});


