<?php

namespace App\Http\Requests\Api\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ReviewProviderApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Make sure route is protected by admin middleware
    }

    public function rules(): array
    {
        return [
            'status' => 'required|in:approved,rejected,requires_changes',
            'rejection_reason' => 'required_if:status,rejected,requires_changes|nullable|string',
            'field_statuses' => 'nullable|array',
            // Example of field_statuses: 
            // { "id_front": {"status": "rejected", "reason": "Not clear"}, "bio": {"status": "approved"} }
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'حالة الطلب مطلوبة.',
            'status.in' => 'حالة الطلب غير صحيحة.',
            'rejection_reason.required_if' => 'سبب الرفض أو التعديل مطلوب في حال عدم الموافقة.',
        ];
    }
}
