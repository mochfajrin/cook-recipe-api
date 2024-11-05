<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix("v1")->group(function () {
    // public api

    Route::prefix("users")->controller(UserController::class)->group(function () {
        Route::post("/register", "register");
        Route::post("/register", "register");
    });
});
