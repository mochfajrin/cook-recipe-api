<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InstructionResponse extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "step" => $this->step,
            "step_order" => $this->step_order,
            "image" => $this->image,
        ];
    }
}
