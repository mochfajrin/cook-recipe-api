<?php

namespace App\Http\Requests\User;

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
            "username" => "string|min:5|max:100|unique:users|required",
            "name" => "string|min:5|max:100|required",
            "password" => "string|min:8|max:100|required",
            "email" => "email|unique:users|min:8|max:255|required",
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
