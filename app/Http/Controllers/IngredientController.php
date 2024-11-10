<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ingredient\IngredientCreateRequest;
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
}
