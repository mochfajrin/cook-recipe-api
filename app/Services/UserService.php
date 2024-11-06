<?php

namespace App\Services;

use App\Http\Requests\user\UserCreateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserService
{
    public function __construct(
        private ImagekitService $imagekitService,
    ) {
    }
    public function register(UserCreateRequest $request)
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
        $token = $user->createToken("access_token")->plainTextToken;
        $user->access_token = $token;

        return $user;
    }
}
