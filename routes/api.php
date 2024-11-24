<?php

use App\Http\Controllers\IngredientController;
use App\Http\Controllers\InstructionController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix("v1")->group(function () {
    // public api

    Route::prefix("users")->controller(UserController::class)->group(function () {
        Route::post("/register", "register");
        Route::post("/login", "login");
    });
    Route::prefix("recipes")->controller(RecipeController::class)->group(function () {
        Route::get("/", "search");
        Route::get("/{id}", "get");
    });
    // private api

    Route::middleware("auth:sanctum")->group(function () {
        Route::prefix("users")->controller(UserController::class)->group(function () {
            Route::get("/current", "get");
            Route::patch("/current", "update");
            Route::delete("/logout", "logout");
        });
        Route::prefix("users")->controller(RecipeController::class)->group(function () {
            Route::get("/recipes", "getPrivateRecipes");
            Route::get("recipes/{id}", "getOnePrivateRecipe");
        });
        Route::prefix("recipes")->group(function () {
            Route::controller(RecipeController::class)->group(function () {
                Route::post("/", "create");
                Route::patch("/{id}", "update");
                Route::delete("/{id}", "delete");
            });
            Route::controller(IngredientController::class)->group(function () {
                Route::post("/{recipeId}/ingredients", "create");
                Route::patch("/{recipeId}/ingredients", "update");
                Route::delete("/{recipeId}/ingredients/{ingredientId}", "delete");
            });
            Route::controller(InstructionController::class)->group(function () {
                Route::post("/{recipeId}/instructions", "create");
                Route::patch("/{recipeId}/instructions", "update");
                Route::delete("/{recipeId}/instructions/{instructionsId}", "delete");
            });
        });
    });
});

