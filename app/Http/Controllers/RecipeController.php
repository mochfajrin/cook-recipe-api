<?php

namespace App\Http\Controllers;

use App\Http\Requests\Recipe\RecipeCreateRequest;
use App\Http\Resources\RecipeResponse;
use App\Services\RecipeService;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function __construct(private RecipeService $recipeService)
    {
    }
    public function create(RecipeCreateRequest $request)
    {
        $recipe = $this->recipeService->createRecipe($request);
        return new RecipeResponse($recipe);
    }
    public function get(int $id)
    {
        $recipe = $this->recipeService->get($id);
        return new RecipeResponse($recipe);
    }

}
