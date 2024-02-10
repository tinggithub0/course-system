<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Resources\CourseResource;
use App\Http\Resources\CourseCollection;
use App\Http\Requests\Course\StoreRequest;
use App\Http\Requests\Course\UpdateRequest;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->page ?? 1;
        $perPage = $request->per_page ?? self::DEFAULT_PER_PAGE;
        $courses = Course::with('teacher')->simplePaginate($perPage, ['*'], 'page', $page);

        return response(new CourseCollection($courses, $page, $perPage), 200);
    }

    public function store(StoreRequest $request)
    {
        $course = Course::create($request->validated());

        return response(new CourseResource($course::with('teacher')->find($course->user_id)), 201);
    }

    public function update(UpdateRequest $request, $id)
    {
        $course = Course::findOrFail($id);

        $course->fill($request->validated());
        if ($course->end_time <= $course->start_time) {
            return response()->json([
                'message' => 'end_time 不能早於 start_time'
            ], 422);
        }

        $course->save();

        return response(new CourseResource($course), 200);
    }

    public function destroy(int $id)
    {
        Course::findOrFail($id)->delete();

        return response(null, 204);
    }
}