<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserLoginRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            "username" => "string|required|min:5|max:100|",
            "password" => "string|required|min:8|max:100",
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
