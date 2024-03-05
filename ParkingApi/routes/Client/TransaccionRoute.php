<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransaccionController;

Route::prefix("transaccion")->group(function () {

    Route::post("/", [TransaccionController::class, "save"]);
    Route::post("/addrange", [TransaccionController::class, "AddRange"]);

    Route::get("/", [TransaccionController::class, "GetPaginate"]);
    Route::get("/{id}", [TransaccionController::class, "GetById"]);
    Route::get("/betweeen/vehiculo", [TransaccionController::class, "GetBetween"]);


    Route::delete("/{id}", [TransaccionController::class, "Delete"]);
    Route::delete("/", [TransaccionController::class, "DeleteRange"]);

    Route::put("/{id}", [TransaccionController::class, "Update"]);
});

