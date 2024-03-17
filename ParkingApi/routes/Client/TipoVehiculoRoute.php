<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TipoVehiculoController;

Route::prefix("tipovehiculo")->group(function () {

    Route::post("/", [TipoVehiculoController::class, "save"]);
    Route::post("/addrange", [TipoVehiculoController::class, "AddRange"]);

    Route::get("/", [TipoVehiculoController::class, "GetPaginate"]);
    Route::get("/{id}", [TipoVehiculoController::class, "GetById"]);

    Route::delete("/{id}", [TipoVehiculoController::class, "Delete"]);
    Route::delete("/", [TipoVehiculoController::class, "DeleteRange"]);

    Route::put("/{id}", [TipoVehiculoController::class, "Update"]);
});

