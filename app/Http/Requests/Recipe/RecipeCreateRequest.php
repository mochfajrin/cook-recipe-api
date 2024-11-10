<?php

namespace App\Http\Requests\Recipe;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RecipeCreateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            "title" => "string|min:8|max:100|required",
            "summary" => "string|max:1000",
            "portion" => "string|max:100",
            "prep_time" => "string|max:50",
            "header_image" => "mimes:png,jpg,jpeg|max:5000",
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response([
            "errors" => $validator->getMessageBag()
        ], 400));
    }
}
