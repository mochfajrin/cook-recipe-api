<?php

namespace App\Http\Controllers;

use App\Http\Requests\Recipe\RecipeCreateRequest;
use App\Http\Requests\Recipe\RecipeUpdateRequest;
use App\Http\Resources\RecipeCollection;
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
        $recipe = $this->recipeService->create($request);
        return new RecipeResponse($recipe);
    }
    public function get(int $id)
    {
        $recipe = $this->recipeService->getOne($id, null);

        return new RecipeResponse($recipe);
    }
    public function update(int $id, RecipeUpdateRequest $request)
    {
        $recipe = $this->recipeService->update($id, $request);
        return new RecipeResponse($recipe);
    }
    public function delete(int $id, Request $request)
    {
        $this->recipeService->delete($id, $request->user()->id);
        return response()->json(["message" => "success"], 200);
    }
    public function search(Request $request)
    {
        $recipes = $this->recipeService->search($request);
        return new RecipeCollection($recipes);
    }
}
