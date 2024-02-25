<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeacherCourseController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/tokens', [TokenController::class, 'store'])
    ->withoutMiddleware('auth:sanctum');

Route::apiResource('teachers', TeacherController::class)
    ->only(['index', 'store']);
Route::apiResource('teachers.courses', TeacherCourseController::class)
    ->only(['index']);

Route::apiResource('courses', CourseController::class)
    ->only(['index', 'store', 'update', 'destroy']);
