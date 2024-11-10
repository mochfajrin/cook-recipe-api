<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IngredientResponse extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "recipe_id" => $this->recipe_id,
            "name" => $this->name,
        ];
    }
}
