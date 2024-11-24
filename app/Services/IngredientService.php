<?php

namespace App\Services;

use App\Http\Requests\Ingredient\IngredientCreateRequest;
use App\Http\Requests\Ingredient\IngredientUpdateRequest;
use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Http\Exceptions\HttpResponseException;

class IngredientService
{
    public function isRecipeExist(int $recipeId, int $userId): Recipe
    {
        $recipe = Recipe::where("id", $recipeId)->where("user_id", $userId)->first();
        if (!$recipe) {
            throw new HttpResponseException(response([
                "errors" => ["Recipe not found"]
            ], 404));
        }
        return $recipe;
    }
    public function getOneIngredient(int $recipeId, int $ingredientId): Ingredient
    {
        $ingredient = Ingredient::where("recipe_id", $recipeId)->where("id", $ingredientId)->first();
        if (!$ingredient) {
            throw new HttpResponseException(response([
                "errors" => ["Ingredient not found"]
            ], 404));
        }
        return $ingredient;
    }
    public function create(int $recipeId, IngredientCreateRequest $request)
    {
        $recipe = $this->isRecipeExist($recipeId, $request->user()->id);
        $data = $request->validated()["ingredients"];
        $ingredient = $recipe->ingredients()->createMany($data);
        return $ingredient;
    }

    public function update(int $recipeId, IngredientUpdateRequest $request)
    {
        $data = $request->validated()["ingredients"];
        $recipe = $this->isRecipeExist($recipeId, $request->user()->id);
        $recipe->ingredients()->upsert($data, "id");
        $ingredients = $recipe->ingredients()->orderBy("id", "ASC")->get(["id", "recipe_id", "name"]);
        return $ingredients;
    }
    public function delete(int $recipeId, int $ingredientId)
    {
        $this->getOneIngredient($recipeId, $ingredientId)->delete();
        return true;
    }
}
