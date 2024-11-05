<?php

namespace App\Http\Controllers;

use App\Http\Requests\user\UserCreateRequest;
use App\Http\Resources\UserResponse;
use App\Services\UserService;
use ImageKit\ImageKit;

class UserController extends Controller
{
    protected UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function register(UserCreateRequest $request)
    {
        // $user = $this->userService->register($request);

        // return new UserResponse($user);

        $image = $request->file("image");
        $imagekit = new ImageKit(env("IMAGEKIT_PUBLIC_KEY"), env("IMAGEKIT_PRIVATE_KEY"), env("IMAGEKIT_URL_ENDPOINT"));
        $currentTime = round(microtime(true) * 1000);
        $uploaded = $imagekit->upload([
            "file" => $image,
            "folder" => "/cook-recipe/user_profile",
            "fileName" => "IMG" . $currentTime . "." . $image->extension(),
        ]);

        return response()->json($uploaded);
    }
}
