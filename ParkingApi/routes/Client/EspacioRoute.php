<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EspacioController;

Route::prefix("espacio")->group(function ()
{
    Route::post("/", [EspacioController::class, "save"]);
    Route::post("/addrange", [EspacioController::class, "AddRange"]);

    Route::get("/", [EspacioController::class, "GetPaginate"]);
    Route::get("/{id}", [EspacioController::class, "GetById"]);
    Route::get("/estado/{estado}", [EspacioController::class, "GetEspacesBy"]);


    Route::delete("/{id}", [EspacioController::class, "Delete"]);
    Route::delete("/", [EspacioController::class, "DeleteRange"]);

    Route::put("/{id}", [EspacioController::class, "Update"]);

});
