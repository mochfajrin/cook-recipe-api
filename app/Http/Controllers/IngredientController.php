<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ingredient\IngredientCreateRequest;
use App\Http\Requests\Ingredient\IngredientUpdateRequest;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Services\IngredientService;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function __construct(private readonly IngredientService $ingredientService)
    {
    }
    public function create($recipeId, IngredientCreateRequest $request)
    {
        $ingredients = $this->ingredientService->create($recipeId, $request);
        return $ingredients;
    }
    public function update($recipeId, IngredientUpdateRequest $request)
    {
        $ingredients = $this->ingredientService->update($recipeId, $request);
        return response()->json($ingredients)->setStatusCode(200);
    }
}
