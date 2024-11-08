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
            $uploaded = $this->imagekitService->uploadProfilePict($image);
            $data["header_image"] = $uploaded->result->url;
            $data["header_image_id"] = $uploaded->result->fileId;
        }
        $data["user_id"] = $request->user()->id;
        $recipe = Recipe::create($data);

        return $recipe;
    }
    public function get(int $id, int $userId)
    {
        $user = User::find($userId)->first();
        $recipe = Recipe::where("id", $id)->where("user_id", $user->id)->first();
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
        $recipe = $this->get($id, $request->user()->id);
        $data = $request->validated();
        $image = $request->file("header_image");
        if ($image) {
            $uploaded = $this->imagekitService->updateRecipePict($image, $recipe->header_image_id);
            $recipe->header_image = $uploaded->result->url;
            $recipe->header_image_id = $uploaded->result->fileId;
        }
        if (isset($data["title"])) {
            $recipe->title = $data["title"];
        }
        if (isset($data["summary"])) {
            $recipe->summary = $data["summary"];
        }
        if (isset($data["portion"])) {
            $recipe->portion = $data["portion"];
        }
        if (isset($data["prep_time"])) {
            $recipe->prep_time = $data["prep_time"];
        }
        if (isset($data["visibility"])) {
            $recipe->visibility = $data["visibility"];
        }
        if (isset($data["private"])) {
            $recipe->private = $data["private"];
        }
        $recipe->save();

        return $recipe;
    }
    public function delete(int $id, int $userId)
    {
        $this->get($id, $userId)->delete();
        return true;
    }
}
