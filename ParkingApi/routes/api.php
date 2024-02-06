<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehiculoController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post("/vehiculo", [VehiculoController::class, "save"]);
Route::post("/vehiculo/addrange", [VehiculoController::class, "AddRange"]);

Route::get("/vehiculo", [VehiculoController::class, "GetPaginate"]);
Route::get("/vehiculo/{id}", [VehiculoController::class, "GetById"]);

Route::delete("/vehiculo/{id}", [VehiculoController::class, "Delete"]);
Route::delete("/vehiculo", [VehiculoController::class, "DeleteRange"]);

Route::put("/vehiculo/{id}", [VehiculoController::class, "Update"]);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
