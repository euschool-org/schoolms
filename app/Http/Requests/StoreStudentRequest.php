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
            'firstname' => 'required|string|max:45',
            'lastname' => 'required|string|max:45',
            'private_number' => 'required|numeric|digits:11',
            'grade' => 'required|integer|min:0|max:12',
            'group' => 'required|in:ა,ბ,გ,დ,A,B,C,D',
            'sector' => 'required|integer',
            'pupil_status' => 'required|integer|in:-1,0,1',
            'additional_information' => 'nullable|string',
        ];
    }
}
