<?php

namespace App\Http\Requests\Ingredient;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Client\HttpClientException;

class IngredientCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user();
    }
    public function rules(): array
    {
        return [
            "name" => "string|min:1|max:100|required"
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpClientException(response([
            "errors" => $this->errorBag(),
            400
        ]));
    }
}
