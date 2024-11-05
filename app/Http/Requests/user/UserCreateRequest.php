<?php

namespace App\Http\Requests\user;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UserCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            "username" => "string|required|min:1|max:100|unique:users",
            "name" => "string|required|min:1|max:100",
            "password" => "string|required|min:1|max:100",
            "email" => "email|required|unique:users|min:8|max:255",
            "address" => "string|min:1|max:100",
            "about_me" => "string|min:1|max:100",
            "image" => "mimes:png,jpg,jpeg|max:5000",
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response([
                "errors" => $validator->getMessageBag()
            ], 400)
        );
    }
}
