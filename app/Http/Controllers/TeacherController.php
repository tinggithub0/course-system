<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\TeacherResource;
use App\Http\Resources\CourseCollection;
use App\Http\Resources\TeacherCollection;
use App\Http\Requests\Teacher\StoreRequest;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->page ?? 1;
        $perPage = $request->per_page ?? self::DEFAULT_PER_PAGE;

        $teachers = User::teachers()
            ->simplePaginate($perPage, ['*'], 'page', $page);

        return response(new TeacherCollection($teachers, $page, $perPage), 200);
    }

    public function store(StoreRequest $request)
    {
        $teacher = [
            ...$request->validated(),
            'role' => 1
        ];
        $user = User::create($teacher);

        return response(new TeacherResource($user), 201);
    }

    public function courses(Request $request, int $teacher_id)
    {
        $page = $request->page ?? 1;
        $perPage = $request->per_page ?? self::DEFAULT_PER_PAGE;

        $courses = User::find($teacher_id)->courses()->simplePaginate($perPage, ['*'], 'page', $page);

        return response(new CourseCollection($courses, $page, $perPage), 200);
    }
}
