<?php

namespace App\Services;

use App\Http\Requests\Recipe\RecipeCreateRequest;
use App\Http\Requests\Recipe\RecipeUpdateRequest;
use App\Models\Recipe;
use App\Models\User;
use App\Services\ImagekitService;
use Illuminate\Http\Exceptions\HttpResponseException;

class RecipeService
{
    public function __construct(private readonly ImagekitService $imagekitService)
    {
    }
    public function createRecipe(RecipeCreateRequest $request)
    {
        $data = $request->validated();
        $image = $request->file("header_image");
        if ($image) {
            $uploaded = $this->imagekitService->uploadImage($image);
            $data["header_image"] = $uploaded->result->url;
            $data["header_image_id"] = $uploaded->result->fileId;
        }
        $data["user_id"] = $request->user()->id;
        $recipe = Recipe::create($data);

        return $recipe;
    }
    public function get(int $id)
    {
        $recipe = Recipe::find($id);
        if (!$recipe) {
            throw new HttpResponseException(response(
                [
                    "errors" => ["Recipe not found"]
                ],
                404
            ));
        }
        return $recipe;
    }
    public function update(int $id, RecipeUpdateRequest $request)
    {
        $recipe = $this->get($id);
        $data = $request->validated();
    }
}
