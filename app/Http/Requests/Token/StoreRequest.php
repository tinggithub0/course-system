<?php

namespace App\Http\Requests\Token;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;

class StoreRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        parent::authorize();

        return $this->user()->role === 1;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => [
                'required',
                'int',
                Rule::exists('users', 'id')->where(function ($query) {
                    $query->whereIn('role', [2, 3]);
                }),
            ],
            'token_name' => 'required|string|max:255',
        ];
    }
}
