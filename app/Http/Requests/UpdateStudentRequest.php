<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
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
            'firstname' => 'nullable|string|max:255',
            'lastname' => 'nullable|string|max:255',
            'private_number' => 'nullable|string|max:255',
            'grade' => 'nullable|integer',
            'group' => 'nullable|in:ა,ბ,გ,დ,A,B,C,D',
            'sector' => 'nullable|integer',
            'pupil_status' => 'nullable|string|max:255',
            'additional_information' => 'nullable|string',
            'contract_end_date' => 'nullable|integer',
            'monthly_payment' => 'nullable|numeric',
            'currency' => 'nullable|string|in:EUR,USD,GEL',
            'parent_account' => 'nullable|string|max:12',
            'income_account' => 'nullable|string|max:10',
            'payment_quantity' => 'nullable|integer|max:10',
            'custom_discount' => 'nullable|numeric|max:100',
            'parent_mail' => 'nullable|email|max:255',
            'parent_number' => 'nullable|string|max:255',
            'email_notifications' => 'nullable|boolean',
            'mobile_notifications' => 'nullable|boolean',
        ];
    }
}
