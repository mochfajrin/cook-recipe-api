<?php

namespace App\Services;

use App\Http\Requests\user\UserCreateRequest;
use App\Http\Requests\user\UserLoginRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\UserResponse;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Hash;
use Log;


class UserService
{
    public function __construct(
        private ImagekitService $imagekitService,
    ) {
    }
    public function register(UserCreateRequest $request): User
    {
        $data = $request->validated();
        $data["password"] = Hash::make($data["password"]);
        $image = $request->file("image");
        if ($image) {
            $uploaded = $this->imagekitService->uploadImage($image);
            $data["image"] = $uploaded->result->url;
            $data["image_id"] = $uploaded->result->fileId;
        }
        $user = User::create($data);

        return $user;
    }
    public function login(UserLoginRequest $request): User
    {
        $data = $request->validated();
        $user = User::where("username", $data["username"])->first();
        if (!$user) {
            throw new HttpResponseException(response(["errors" => ["username or password not found"]], 401));
        }

        $isPasswordCorrect = Hash::check($data["password"], $user["password"]);

        if (!$isPasswordCorrect) {
            throw new HttpResponseException(response(["errors" => ["username or password not found"]], 401));
        }
        $token = $user->createToken("access_token")->plainTextToken;
        $user["access_token"] = $token;
        return $user;
    }
    public function get(string $id): User
    {
        $user = User::where("id", $id)->first();
        if (!$user) {
            throw new HttpResponseException(response(["errors" => ["user not found"]], 404));
        }
        return $user;
    }
    public function update(UserUpdateRequest $request)
    {
        $data = $request->validated();
        $user = User::find($request->user()->id);
        $image = $request->file("image");

        if ($image) {
            $upload = $this->imagekitService->updateImage($image, $user->file_id);
            $user->image = $upload->result->url;
            $user->image_id = $upload->result->fileId;
        }
        if (isset($data["username"])) {
            $user->username = $data["username"];
        }
        if (isset($data["password"])) {
            $user->password = $data["password"];
        }
        if (isset($data["name"])) {
            $user->name = $data["name"];
        }
        if (isset($data["about_me"])) {
            $user->about_me = $data["about_me"];
        }

        $user->save();
        return $user;
    }
}
