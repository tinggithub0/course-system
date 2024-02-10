<?php

namespace App\Http\Requests\Course;

use App\Http\Requests\BaseRequest;

class StoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'teacher_id' => 'required|exists:users,id,role,1',
            'name' => 'required|string|max:255',
            'introduction' => 'required|string',
            'start_time' => 'required|date_format:Hi',
            'end_time' => 'required|date_format:Hi|after:start_time',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            '*.required' => ':attribute is required',
        ];
    }
}
