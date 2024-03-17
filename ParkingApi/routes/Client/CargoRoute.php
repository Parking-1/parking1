<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CargoController;

Route::prefix("cargo")->group(function ()
{
    Route::post("/", [CargoController::class, "save"]);
    Route::post("/addrange", [CargoController::class, "AddRange"]);

    Route::get("/", [CargoController::class, "GetPaginate"]);
    Route::get("/{id}", [CargoController::class, "GetById"]);


    Route::delete("/{id}", [CargoController::class, "Delete"]);
    Route::delete("/", [CargoController::class, "DeleteRange"]);

    Route::put("/{id}", [CargoController::class, "Update"]);

});
