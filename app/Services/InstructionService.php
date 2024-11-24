<?php

namespace App\Services;

use App\Http\Requests\Instruction\InstructionCreateRequest;
use App\Models\Instruction;
use App\Models\Recipe;
use Illuminate\Http\Exceptions\HttpResponseException;

class InstructionService
{
    public function __construct(private readonly ImagekitService $imagekitService)
    {
    }
    public function getOneRecipe($recipeId)
    {
        $recipe = Recipe::find($recipeId);
        if (!$recipe) {
            throw new HttpResponseException(response(["errors" => ["Recipe not found"]], 404));
        }
        return $recipe;
    }
    public function create(int $recipeId, InstructionCreateRequest $request)
    {
        $data = $request->validated()["instructions"];
        $recipe = $this->getOneRecipe($recipeId);


        foreach ($data as $index => $value) {
            $image = $request->file("instructions.{$index}.image");
            if (isset($image)) {
                $uploaded = $this->imagekitService->uploadStepPict($image);
                $data[$index]["image"] = $uploaded->result->url;
                $data[$index]["image_id"] = $uploaded->result->fileId;
            }
        }
        $instructions = $recipe->instructions()->createMany($data);
        return $instructions;
    }
}
