<?php

namespace App\Http\Requests\Teacher\Course;

use App\Models\User;
use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Validator;

class IndexRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $validator = Validator::make(['id' => $this->route('teacher')], [
            'id' => [
                'required',
                'integer',
                Rule::exists('users', 'id')->where(function (Builder $query) {
                    return $query->where('role', User::ROLE_TEACHER);
                }),
            ]
        ]);

        if ($validator->fails()) {
            return false;
        }

        return true;
    }
}
