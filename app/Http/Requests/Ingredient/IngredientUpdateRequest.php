<?php

namespace App\Http\Requests\Ingredient;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class IngredientUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }
    public function rules(): array
    {
        return [
            "ingredients.*.recipe_id" => "int|min:1|required",
            "ingredients.*.name" => "string|min:1|max:100|required"
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response([
            "errors" => $validator->getMessageBag(),
        ], 400));
    }
}
