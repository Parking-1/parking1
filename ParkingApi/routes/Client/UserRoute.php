<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::prefix("user")->group(function () {
    // Autenticación
    Route::post('/register', [UserController::class, "register"]);
    Route::post('/login', [UserController::class, "authenticate"]);
    Route::post('/logout', [UserController::class, "logOut"]);

    // Verificación
    Route::post('/verifyEmail', [UserController::class, "GetIfExistsEmail"]);
});

