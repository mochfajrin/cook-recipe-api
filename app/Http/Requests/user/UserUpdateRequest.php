<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }
    public function rules(): array
    {
        return [
            "username" => "string|min:5|max:100|unique:users",
            "name" => "string|min:5|max:100",
            "password" => "string|min:8|max:100",
            "address" => "string|min:1|max:100",
            "about_me" => "string|min:1|max:100",
            "image" => "mimes:png,jpg,jpeg|max:5000",
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response(
                ["errors" => $validator->getMessageBag()],
                400
            )
        );
    }
}
