<?php

use App\Http\Controllers\RecipeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix("v1")->group(function () {
    // public api

    Route::prefix("users")->controller(UserController::class)->group(function () {
        Route::post("/register", "register");
        Route::post("/login", "login");
    });

    // private api

    Route::middleware("auth:sanctum")->group(function () {
        Route::prefix("users")->controller(UserController::class)->group(function () {
            Route::get("/current", "get");
            Route::patch("/current", "update");
            Route::delete("/logout", "logout");
        });
        Route::prefix("recipes")->controller(RecipeController::class)->group(function () {
            Route::get("/", "search");
            Route::post("/", "create");
            Route::get("/{id}", "get")->where("id", "[0-9]+");
            Route::patch("/{id}", "update")->where("id", "[0-9]+");
            Route::delete("/{id}", "delete")->where("id", "[0-9]+");
        });
    });
});

