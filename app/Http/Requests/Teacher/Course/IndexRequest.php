<?php

namespace App\Http\Requests\Teacher\Course;

use App\Rules\HasRole;
use App\Enums\UserRole;
use App\Http\Requests\BaseRequest;
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
                new HasRole(UserRole::TEACHER->value),
            ]
        ]);

        if ($validator->fails()) {
            return false;
        }

        return true;
    }
}
