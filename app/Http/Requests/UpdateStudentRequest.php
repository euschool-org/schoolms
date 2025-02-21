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
            'name' => 'nullable|string|max:191',
            'private_number' => 'nullable|string|max:45',
            'grade' => 'nullable|integer|max:12',
            'group' => 'nullable|in:ა,ბ,გ,დ,ე,ვ,ზ,თ,ი,კ,A,B,C,D,E,F,G,H,I,J,ქართული,ინგლისური',
            'sector' => 'nullable|in:ქართული,IB,ASAS,ბაღი',
            'additional_information' => 'nullable|string',
            'contract_start_date' => 'nullable|date',
            'contract_end_date' => 'nullable|date',
            'currency' => 'nullable|string|exists:currencies,code',
            'parent_account' => 'nullable|string|max:25',
            'income_account' => 'nullable|string|max:12',
            'new_student_discount' => 'nullable|boolean',
            'parent_name' => 'nullable|string|max:191',
            'parent_mail' => 'nullable|email|max:255',
            'parent_number' => 'nullable|numeric',
            'email_notifications' => 'nullable|boolean',
        ];
    }
}
