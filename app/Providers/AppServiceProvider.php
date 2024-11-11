<?php

namespace App\Providers;

use App\Services\ImagekitService;
use App\Services\RecipeService;
use App\Services\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use ImageKit\ImageKit;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ImageKit::class, function () {
            return new ImageKit(
                env("IMAGEKIT_PUBLIC_KEY"),
                env("IMAGEKIT_PRIVATE_KEY"),
                env("IMAGEKIT_URL_ENDPOINT")
            );
        });
        $this->app->singleton(ImagekitService::class, function (Application $app) {
            $imagekit = $app->make(ImageKit::class);
            return new ImagekitService($imagekit);
        });
        $this->app->singleton(UserService::class, function (Application $app) {
            $imagekitService = $app->make(ImagekitService::class);
            return new UserService($imagekitService);
        });
        $this->app->singleton(RecipeService::class, function (Application $app) {
            $imagekitService = $app->make(ImagekitService::class);
            return new RecipeService($imagekitService);
        });
    }
    public function boot(): void
    {
        Route::pattern("userId", "[0-9]+");
        Route::pattern("recipeId", "[0-9]+");
        Route::pattern("ingredientId", "[0-9]+");
        Route::pattern("instructionId", "[0-9]+");
        Route::pattern("recipeCollectionId", "[0-9]+");
    }
}
