<?php

namespace App\Services;

use App\Http\Requests\user\UserCreateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Services\ImagekitService;


class UserService
{
    public function register(UserCreateRequest $request)
    {
        $data = $request->validated();
        $data["password"] = Hash::make($data["password"]);

        $image = $request->file("image");
        if ($image) {
            $imagekit = new ImagekitService();
            $uploaded = $imagekit->uploadImage($image);
            $data["image"] = $uploaded["url"];
            $data["image_id"] = $uploaded["file_id"];
        }


        $user = User::create($data);
        $token = $user->createToken("access_token")->plainTextToken;
        $user->access_token = $token;

        return $user;
    }
}
