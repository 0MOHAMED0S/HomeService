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
            'birthdate' => 'nullable|date',
            'phone' => 'required|string|max:20',
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
            'email.max' => 'البريد الإلكتروني يجب أن لا يتجاوز 255 حرفاً.',
            'name.required' => 'الاسم مطلوب.',
            'name.string' => 'الاسم يجب أن يكون نصاً.',
            'name.max' => 'الاسم يجب أن لا يتجاوز 255 حرفاً.',
            'password.required' => 'كلمة المرور مطلوبة.',
            'password.string' => 'كلمة المرور غير صالحة.',
            'password.min' => 'كلمة المرور يجب أن لا تقل عن 8 أحرف.',
            'password.confirmed' => 'كلمة المرور غير متطابقة.',
            'password.regex' => 'كلمة المرور يجب أن تحتوي على أحرف إنجليزية (كبيرة وصغيرة)، أرقام، ورموز (مثل #, $, %).',

            'birthdate.date' => 'تاريخ الميلاد غير صحيح.',
            'phone.required' => 'رقم الهاتف مطلوب.',
            'phone.string' => 'رقم الهاتف غير صالح.',
            'phone.max' => 'رقم الهاتف يجب أن لا يتجاوز 20 حرفاً.',
            'role.required' => 'النوع مطلوب.',
            'role.in' => 'النوع المحدد غير صحيح.',
            'privacy_agree.accepted' => 'يجب الموافقة على سياسة الخصوصية.',
        ];
    }
}
