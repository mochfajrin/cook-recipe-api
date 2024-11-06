<?php

namespace App\Providers;

use App\Services\ImagekitService;
use App\Services\UserService;
use Illuminate\Contracts\Foundation\Application;
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
    }
    public function boot(): void
    {
    }
}
