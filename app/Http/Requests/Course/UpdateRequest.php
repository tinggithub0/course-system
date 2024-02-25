<?php

namespace App\Http\Requests\Course;

use App\Http\Requests\BaseRequest;

class UpdateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        parent::authorize();

        return $this->user()->role === 2;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'teacher_id' => 'exists:users,id,role,2',
            'name' => 'string|max:255',
            'introduction' => 'string',
            'start_time' => 'date_format:Hi',
            'end_time' => 'date_format:Hi|after:start_time',
        ];
    }
}
