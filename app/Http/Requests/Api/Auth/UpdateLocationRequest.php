<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLocationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'longitude.required' => 'خط الطول مطلوب.',
            'longitude.numeric' => 'خط الطول يجب أن يكون رقماً.',
            'latitude.required' => 'خط العرض مطلوب.',
            'latitude.numeric' => 'خط العرض يجب أن يكون رقماً.',
        ];
    }
}
