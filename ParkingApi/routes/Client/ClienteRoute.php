<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;

Route::prefix("cliente")->group(function ()
{
    Route::post("/", [ClienteController::class, "save"]);
    Route::post("/addrange", [ClienteController::class, "AddRange"]);

    Route::get("/", [ClienteController::class, "GetPaginate"]);
    Route::get("/{id}", [ClienteController::class, "GetById"]);
    Route::get("/relac/get", [ClienteController::class, "GetWithVehiculo"]);


    Route::delete("/{id}", [ClienteController::class, "Delete"]);
    Route::delete("/", [ClienteController::class, "DeleteRange"]);

    Route::put("/{id}", [ClienteController::class, "Update"]);

});

