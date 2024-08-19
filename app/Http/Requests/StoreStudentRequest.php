<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
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
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'private_number' => 'required|string|max:255',
            'grade' => 'required|integer',
            'sector' => 'required|integer',
            'parent_mail' => 'required|email|max:255',
            'parent_number' => 'required|string|max:255',
            'pupil_status' => 'required|string|max:255',
            'additional_information' => 'nullable|string',
        ];
    }
}
