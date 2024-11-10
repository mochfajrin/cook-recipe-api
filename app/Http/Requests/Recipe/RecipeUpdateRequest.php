<?php

namespace App\Http\Requests\Recipe;

use App\Enums\RecipeVisibility;
use App\Models\Recipe;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class RecipeUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        $userId = $this->user()->id;
        $recipe = Recipe::where("user_id", $userId)->count();
        return $recipe !== 0;
    }
    public function rules(): array
    {
        return [
            "title" => "string|min:8|max:100",
            "summary" => "string|max:1000",
            "portion" => "string|max:100",
            "prep_time" => "string|max:50",
            "is_public" => "boolean",
            "header_image" => "mimes:png,jpg,jpeg|max:5000|",
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response([
            "errors" => $validator->getMessageBag()
        ], 400));
    }
}
