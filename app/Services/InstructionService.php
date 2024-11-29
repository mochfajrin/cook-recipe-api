<?php

namespace App\Services;

use App\Http\Requests\Instruction\InstructionCreateRequest;
use App\Http\Requests\Instruction\InstructionUpdateRequest;
use App\Models\Instruction;
use App\Models\Recipe;
use Illuminate\Http\Exceptions\HttpResponseException;

class InstructionService
{
    public function __construct(private readonly ImagekitService $imagekitService)
    {
    }
    public function getOneRecipe($recipeId, $userId)
    {
        $recipe = Recipe::where("id", $recipeId)->where("user_id", $userId)->first();
        if (!$recipe) {
            throw new HttpResponseException(response(["errors" => ["Recipe not found"]], 404));
        }
        return $recipe;
    }
    public function create(int $recipeId, InstructionCreateRequest $request)
    {
        $recipe = $this->getOneRecipe($recipeId, $request->user()->id);
        $isInstructionsExist = $recipe->instructions()->exists();
        if ($isInstructionsExist) {
            throw new HttpResponseException(response(["errors" => ["Instructions already exists, use patch instead"]], 400));
        }

        $data = $request->validated()["instructions"];
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
    public function update(int $recipeId, InstructionUpdateRequest $request)
    {
        $recipe = $this->getOneRecipe($recipeId, $request->user()->id);
        $isInstructionsExist = $recipe->instructions()->exists();

        if (!$isInstructionsExist) {
            throw new HttpResponseException(response(["errors" => ["Instructions not exists, use post instead"]], 400));
        }

        $data = $request->validated()["instructions"];
        foreach ($data as $index => $value) {
            $image = $request->file("instructions.{$index}.image");
            if (isset($image)) {
                $uploaded = $this->imagekitService->uploadStepPict($image);
                $data[$index]["image"] = $uploaded->result->url;
                $data[$index]["image_id"] = $uploaded->result->fileId;
            }
        }

        $recipe->instructions()->upsert($data, "id");
        $instructions = $recipe->instructions()->orderBy(
            "step_order",
            "ASC"
        )->get(["id", "step_order", "step", "image"]);
        return $instructions;
    }

    public function delete($recipeId, $instructionId)
    {
        $instruction = Instruction::where("id", $instructionId)->where("recipe_id", $recipeId)->delete();
        if (!$instruction) {
            throw new HttpResponseException(response(["errors" => ["Instruction not found"]], 404));
        }
        return true;
    }
}
