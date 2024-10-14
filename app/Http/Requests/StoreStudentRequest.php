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
            'private_number' => 'nullable|numeric',
            'grade' => 'nullable|in:1,2,3,4,5,6,7,8,9,10,11,12,ქართული,ინგლისური',
            'group' => 'nullable|in:ა,ბ,გ,დ,ე,ვ,ზ,თ,ი,კ,A,B,C,D,E,F,G,H,I,J',
            'sector' => 'nullable|in:ქართული,IB,ASAS,ბაღი',
            'pupil_status' => 'nullable|integer|in:-1,0,1',
            'additional_information' => 'nullable|string',
        ];
    }
}
