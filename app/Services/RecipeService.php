<?php

namespace App\Services;

use App\Enums\RecipeVisibility;
use App\Http\Requests\Recipe\RecipeCreateRequest;
use App\Http\Requests\Recipe\RecipeUpdateRequest;
use App\Models\Recipe;
use App\Models\User;
use App\Services\ImagekitService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class RecipeService
{
    public function __construct(private readonly ImagekitService $imagekitService)
    {
    }
    public function create(RecipeCreateRequest $request)
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
    public function getOne(int $id, ?int $userId)
    {
        $recipe = null;
        if ($userId) {
            $user = User::find($userId);
            $recipe = Recipe::where("id", $id)->where("user_id", $user->id)->first();
        } else {
            $recipe = Recipe::where("id", $id)->where("is_public", true)->first();
        }
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
    public function update(int $id, RecipeUpdateRequest $request): Recipe
    {
        $recipe = $this->getOne($id, $request->user()->id);
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
        if (isset($data["is_public"])) {
            $recipe->is_public = $data["is_public"] === "1" || 1 ? true : false;
        }
        $recipe->save();

        return $recipe;
    }
    public function delete(int $id, int $userId)
    {
        $this->getOne($id, $userId)->delete();
        return true;
    }
    public function search(
        Request $request,
    ) {
        $page = $request->input("page", 1);
        $size = $request->input("size", 10);
        $search = $request->input("search");

        $contacts = Recipe::where("is_public", true);

        if ($search) {
            $contacts = $contacts->where("title", "ilike", "%{$search}%");
        }

        $contacts = $contacts->paginate(perPage: $size, page: $page);
        return $contacts;
    }
}
