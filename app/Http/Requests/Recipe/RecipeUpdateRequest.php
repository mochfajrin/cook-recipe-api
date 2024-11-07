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
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }
    public function rules(): array
    {
        return [
            "title" => "string|min:8|max:100",
            "summary" => "string|max:1000",
            "portion" => "string|max:100",
            "prep_time" => "string|max:50",
            "visibility" => [Rule::enum(RecipeVisibility::class)],
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response([
            "errors" => $validator->errors()
        ], 400));
    }
}
