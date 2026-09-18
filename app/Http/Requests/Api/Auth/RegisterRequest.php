<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email' => 'required|email|max:255|unique:users,email',
            'name' => 'required|string|max:255',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/'
            ],
            'longitude' => 'nullable|numeric|between:-180,180',
            'latitude' => 'nullable|numeric|between:-90,90',
            'birthdate' => 'nullable|date',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:user,provider',
            'privacy_agree' => 'accepted',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'صيغة البريد الإلكتروني غير صحيحة.',
            'email.unique' => 'البريد الإلكتروني مستخدم مسبقاً.',
            'name.required' => 'الاسم مطلوب.',
            'password.required' => 'كلمة المرور مطلوبة.',
            'password.min' => 'كلمة المرور يجب أن لا تقل عن 8 أحرف.',
            'password.confirmed' => 'كلمة المرور غير متطابقة.',
            'password.regex' => 'كلمة المرور يجب أن تحتوي على أحرف إنجليزية (كبيرة وصغيرة)، أرقام، ورموز (مثل #, $, %).',
            'longitude.required' => 'خط الطول مطلوب.',
            'longitude.numeric' => 'خط الطول يجب أن يكون رقماً.',
            'longitude.between' => 'خط الطول يجب أن يكون بين -180 و 180.',
            'latitude.required' => 'خط العرض مطلوب.',
            'latitude.numeric' => 'خط العرض يجب أن يكون رقماً.',
            'latitude.between' => 'خط العرض يجب أن يكون بين -90 و 90.',
            'birthdate.date' => 'تاريخ الميلاد غير صحيح.',
            'role.required' => 'النوع مطلوب.',
            'role.in' => 'النوع المحدد غير صحيح.',
            'privacy_agree.accepted' => 'يجب الموافقة على سياسة الخصوصية.',
        ];
    }
}
