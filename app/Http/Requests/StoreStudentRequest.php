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
            'private_number' => 'nullable|numeric',
            'grade' => 'nullable|integer|max:12',
            'group' => 'nullable|in:ა,ბ,გ,დ,ე,ვ,ზ,თ,ი,კ,A,B,C,D,E,F,G,H,I,J,ქართული,ინგლისური',
            'sector' => 'nullable|in:ქართული,IB,ASAS,ბაღი',
            'pupil_status' => 'nullable|integer|in:-1,0,1',
            'additional_information' => 'nullable|string',
        ];
    }
}
