<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::prefix("user")->group(function () {
    Route::post('/register', [UserController::class, "register"]);
    Route::post('/login', [UserController::class, "authenticate"]);
    Route::post('/verifyEmail',[UserController::class, "GetIfExistsEmail"]);

});

Route::prefix('user')->group(function () {
    Route::post('/logout', [UserController::class, "logOut"]);
});
