<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResponse extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "username" => $this->username,
            "name" => $this->name,
            "about_me" => $this->about_me,
            "image" => $this->image,
            "access_token" => $this->access_token
        ];
    }
}
