<?php

namespace App\Http\Requests\Api\Provider;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SubmitProviderProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Middleware handles auth
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'profession_id' => 'required|exists:professions,id',
            'skills' => 'required|array',
            'skills.*' => 'string|max:255',
            'languages' => 'required|array',
            'languages.*' => 'string|max:255',
            'experience_years' => 'required|integer|min:0',
            'bio' => 'required|string|max:1000',
            'longitude' => 'required|numeric|between:-180,180',
            'latitude' => 'required|numeric|between:-90,90',
            
            // Files (max 2MB = 2048 KB)
            'profile_picture' => 'nullable|file|mimes:png,jpg,jpeg|max:2048',
            'id_front' => 'nullable|file|mimes:png,pdf,jpg,jpeg|max:2048',
            'id_back' => 'nullable|file|mimes:png,pdf,jpg,jpeg|max:2048',
            'police_clearance' => 'nullable|file|mimes:png,pdf,jpg,jpeg|max:2048',
            'commercial_register' => 'nullable|file|mimes:png,pdf,jpg,jpeg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'profession_id.required' => 'يرجى اختيار المهنة أولاً.',
            'profession_id.exists' => 'المهنة المختارة غير موجودة.',
            'skills.required' => 'المهارات مطلوبة.',
            'languages.required' => 'اللغات مطلوبة.',
            'experience_years.required' => 'سنوات الخبرة مطلوبة.',
            'bio.required' => 'نبذة مختصرة عنك مطلوبة.',
            'longitude.required' => 'خط الطول مطلوب.',
            'longitude.between' => 'خط الطول يجب أن يكون بين -180 و 180.',
            'latitude.required' => 'خط العرض مطلوب.',
            'latitude.between' => 'خط العرض يجب أن يكون بين -90 و 90.',
            'profile_picture.max' => 'حجم الصورة يجب ألا يتجاوز 2 ميجابايت.',
            'id_front.mimes' => 'يجب أن يكون الملف بصيغة PNG أو PDF أو JPG.',
            'id_front.max' => 'حجم الملف يجب ألا يتجاوز 2 ميجابايت.',
            'id_back.mimes' => 'يجب أن يكون الملف بصيغة PNG أو PDF أو JPG.',
            'id_back.max' => 'حجم الملف يجب ألا يتجاوز 2 ميجابايت.',
            'police_clearance.mimes' => 'يجب أن يكون الملف بصيغة PNG أو PDF أو JPG.',
            'police_clearance.max' => 'حجم الملف يجب ألا يتجاوز 2 ميجابايت.',
            'commercial_register.mimes' => 'يجب أن يكون الملف بصيغة PNG أو PDF أو JPG.',
            'commercial_register.max' => 'حجم الملف يجب ألا يتجاوز 2 ميجابايت.',
        ];
    }
}
