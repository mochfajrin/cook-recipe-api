<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserLoginRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\UserResponse;
use App\Services\UserService;
use Illuminate\Http\Request;


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
    public function login(UserLoginRequest $request)
    {
        $user = $this->userService->login($request);
        return response()->json(new UserResponse($user))->setStatusCode(200);
    }
    public function get(Request $request)
    {
        $user = $request->user();
        // $id = $request->user()->id;
        // $user = $this->userService->get($id);
        return response()->json(new UserResponse($user))->setStatusCode(200);
    }
    public function update(UserUpdateRequest $request)
    {
        $user = $this->userService->update($request);
        return response()->json(new UserResponse($user))->setStatusCode(200);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(["message" => "success"])->setStatusCode(200);
    }
}
