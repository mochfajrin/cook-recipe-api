<?php

namespace App\Http\Controllers;

use App\Services\RecipeCollectionService;
use Illuminate\Http\Request;


class RecipeCollectionController extends Controller
{
    public function __construct(
        private readonly RecipeCollectionService $recipeCollectionService
    ) {
    }
    public function create(int $recipeId, Request $request)
    {
        $this->recipeCollectionService->create($recipeId, $request->user()->id);
        return response(["message" => "success"], 201);
    }
    public function get(Request $request)
    {
        $recipeCollections = $this->recipeCollectionService->get($request->user()->id);
        return response()->json($recipeCollections);
    }
    public function delete(int $recipeCollectionId, Request $request)
    {
        $this->recipeCollectionService->delete($recipeCollectionId, $request->user()->id);
        return response(["message" => "success"], 200);
    }
}
