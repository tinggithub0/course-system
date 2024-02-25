<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\CourseCollection;
use App\Http\Requests\Teacher\Course\IndexRequest;

class TeacherCourseController extends Controller
{
    public function index(IndexRequest $request, int $teacher)
    {
        $page = $request->page ?? 1;
        $perPage = $request->per_page ?? self::DEFAULT_PER_PAGE;

        $courses = User::find($teacher)
            ->courses()
            ->simplePaginate($perPage, ['*'], 'page', $page);

        return response(new CourseCollection($courses, $page, $perPage), 200);
    }
}
