<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use App\Http\Resources\TeacherResource;
use App\Http\Resources\TeacherCollection;
use App\Http\Requests\Teacher\StoreRequest;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->page ?? 1;
        $perPage = $request->per_page ?? self::DEFAULT_PER_PAGE;

        $teachers = User::role(UserRole::TEACHER->value)
            ->simplePaginate($perPage, ['*'], 'page', $page);

        return response(new TeacherCollection($teachers, $page, $perPage), 200);
    }

    public function store(StoreRequest $request)
    {
        $teacher = [
            ...$request->validated(),
        ];
        $user = User::create($teacher);
        $user->assignRole(UserRole::TEACHER->value);

        return response(new TeacherResource($user), 201);
    }
}
