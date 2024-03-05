<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TarifaController;

Route::prefix("tarifa")->group(function () {

    Route::post("/", [TarifaController::class, "save"]);
    Route::post("/addrange", [TarifaController::class, "AddRange"]);

    Route::get("/", [TarifaController::class, "GetPaginate"]);
    Route::get("/{id}", [TarifaController::class, "GetById"]);

    Route::delete("/{id}", [TarifaController::class, "Delete"]);
    Route::delete("/", [TarifaController::class, "DeleteRange"]);

    Route::put("/{id}", [TarifaController::class, "Update"]);
});

