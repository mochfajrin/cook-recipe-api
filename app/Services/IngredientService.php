<?php

namespace App\Services;

use App\Http\Requests\Ingredient\IngredientCreateRequest;
use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class IngredientService
{
    public function isRecipeExist(int $recipeId): Recipe
    {
        $recipe = Recipe::find($recipeId);
        if (!$recipeId) {
            throw new HttpResponseException(response([
                "errors" => ["Recipe not found"]
            ], 404));
        }
        return $recipe;
    }
    public function create(int $recipeId, IngredientCreateRequest $request)
    {
        $recipe = $this->isRecipeExist($recipeId);
        $data = $request->validated()["ingredients"];
        $ingredient = $recipe->ingredients()->createMany($data);
        return $ingredient;
    }
}
