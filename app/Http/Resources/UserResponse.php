<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResponse extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "message" => "success",
            "data" => [
                "id" => $this->id,
                "username" => $this->username,
                "name" => $this->name,
                "about_me" => $this->about_me,
                "image" => $this->image,
            ],
            "access_token" => $this->whenNotNull($this->access_token),
            "token_type" => $this->when($this->access_token, "Bearer")
        ];
    }
}
