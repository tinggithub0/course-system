<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\TeacherResource;
use App\Http\Resources\TeacherCollection;
use App\Http\Requests\Teacher\StoreRequest;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $page = (int) $request->page ?? 1;
        $perPage = (int) $request->per_page ?? self::DEFAULT_PER_PAGE;

        $teachers = User::teachers()
            ->simplePaginate($perPage, ['*'], 'page', $page);

        return response(new TeacherCollection($teachers, $page, $perPage), 200);
    }

    public function store(StoreRequest $request)
    {
        $teacher = [
            ...$request->validated(),
            'role' => User::ROLE_TEACHER,
        ];
        $user = User::create($teacher);

        return response(new TeacherResource($user), 201);
    }
}
