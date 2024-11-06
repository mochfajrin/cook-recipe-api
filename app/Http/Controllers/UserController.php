<?php

namespace App\Http\Controllers;

use App\Http\Requests\user\UserCreateRequest;
use App\Http\Resources\UserResponse;
use App\Services\ImagekitService;
use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(private readonly UserService $userService)
    {
    }
    public function register(UserCreateRequest $request)
    {
        $user = $this->userService->register($request);
        return new UserResponse($user);
    }
}
