<?php

namespace App\Http\Requests\Instruction;

use Illuminate\Foundation\Http\FormRequest;

class InstructionCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "instructions.*.step" => "string|min:1|max:1000|required",
            "instructions.*.step_order" => "numeric|min:1|required",
            "instructions.*.image" => "mimes:png,jpg,jpeg|max:5000",
        ];
    }
}
