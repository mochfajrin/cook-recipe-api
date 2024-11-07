<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeResponse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "status" => "success",
            "data" => [
                "id" => $this->id,
                "cheff" => $this->user->name,
                "title" => $this->title,
                "summary" => $this->summary,
                "portion" => $this->portion,
                "prep_time" => $this->prep_time,
                "vicibility" => $this->vicibility,
                "header_image" => $this->header_image,
            ]
        ];
    }
}
