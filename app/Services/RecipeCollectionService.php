<?php
namespace App\Services;

use App\Models\Recipe;
use App\Models\RecipeCollection;
use App\Models\User;
use App\Services\ImagekitService;
use Illuminate\Http\Exceptions\HttpResponseException;


class RecipeCollectionService
{
    public function __construct(
        private readonly ImagekitService $imagekitService
    ) {
    }
    public function create(int $recipeId, $userId)
    {
        $user = User::where("id", $userId)->first();
        if (!$user) {
            throw new HttpResponseException(response(
                ["errors" => ["User not found"]],
                404
            ));
        }

        $isExits = $user->recipeCollections()->where("recipe_id", $recipeId)->first();
        if ($isExits) {
            throw new HttpResponseException(response(
                ["message" => ["Already favorite"]]
                ,
                400
            ));
        }

        $recipe = Recipe::where("id", $recipeId)->first();
        if (!$recipe) {
            throw new HttpResponseException(response(
                ["errors" => ["Recipe not found"]],
                404
            ));
        }
        $user->recipeCollections()->create(["recipe_id" => $recipeId]);
        return true;
    }
    public function get(int $userId)
    {
        $recipeCollections = Recipe::select(["recipes.id", "recipe_collections.id as collection_id", "title"])->join(
            "recipe_collections",
            "recipe_collections.recipe_id",
            "=",
            "recipes.id"
        )->where("recipe_collections.user_id", $userId)->get();
        return $recipeCollections;
    }
    public function delete(int $recipeCollectionId, int $userId)
    {
        $recipeCollection = RecipeCollection::where(
            "id",
            $recipeCollectionId
        )->where("user_id", $userId)->first();
        if (!$recipeCollection) {
            throw new HttpResponseException(
                response(["errors" => ["Recipe collection not found"]], 404)
            );
        }

        $recipeCollection->delete();
        return true;
    }
}
