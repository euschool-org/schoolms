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
            'name' => 'required|string|max:191',
            'private_number' => 'nullable|string|max:45|unique:students,private_number',
            'grade' => 'nullable|integer|max:12',
            'group' => 'nullable|in:ა,ბ,გ,დ,ე,ვ,ზ,თ,ი,კ,A,B,C,D,E,F,G,H,I,J,ქართული,ინგლისური',
            'sector' => 'nullable|in:ქართული,IB,ASAS,ბაღი',
            'additional_information' => 'nullable|string',
        ];
    }
}
