<?php

namespace App\Http\Requests\Instruction;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class InstructionCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }
    public function rules(): array
    {
        return [
            "instructions.*.step" => "string|min:1|max:1000|required",
            "instructions.*.step_order" => "integer|min:1|required",
            "instructions.*.image" => "mimes:png,jpg,jpeg|max:5000",
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response(
            ["errors" => $validator->getMessageBag()],
            400
        ));
    }
}
