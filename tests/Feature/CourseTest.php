<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CourseTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_courses()
    {
        $perPage = 5;
        $page = 1;
        $courses = Course::factory()->count($perPage)->create();

        $response = $this->get("/api/courses?page={$page}&per_page={$perPage}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'introduction',
                        'start_time',
                        'end_time',
                        'teacher' => [
                            'id',
                            'name',
                            'email',
                        ]
                    ]
                ],
                'meta' => [
                    'page',
                    'per_page',
                    'next_page'
                ]
            ]);

        $responseCourses = $response->json('data');
        $this->assertCount($perPage, $responseCourses);

        foreach ($courses as $index => $course) {
            $this->assertEquals($course->id, $responseCourses[$index]['id']);
            $this->assertEquals($course->name, $responseCourses[$index]['name']);
            $this->assertEquals($course->introduction, $responseCourses[$index]['introduction']);
            $this->assertEquals(Carbon::parse($course->start_time)->format('Hi'), $responseCourses[$index]['start_time']);
            $this->assertEquals(Carbon::parse($course->end_time)->format('Hi'), $responseCourses[$index]['end_time']);
            $this->assertEquals($course->teacher->id, $responseCourses[$index]['teacher']['id']);
            $this->assertEquals($course->teacher->name, $responseCourses[$index]['teacher']['name']);
            $this->assertEquals($course->teacher->email, $responseCourses[$index]['teacher']['email']);
        }
    }

    public function test_store_course()
    {
        $teacher_id = User::factory()->create(['role' => 1])->id;

        $courseData = [
            'teacher_id' => $teacher_id,
            'name' => 'Test Course',
            'introduction' => 'This is a test course',
            'start_time' => Carbon::now()->format('Hi'),
            'end_time' => Carbon::now()->addHour()->format('Hi'),
        ];

        $response = $this->post('/api/courses', $courseData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'name',
                'introduction',
                'start_time',
                'end_time',
                'teacher' => [
                    'id',
                    'name',
                    'email',
                ]
            ]);
    }

    public function test_update_course()
    {
        $course = Course::factory()->create();

        $newStartTime = Carbon::now()->format('Hi');
        $newEndTime = Carbon::now()->addHour()->format('Hi');

        $newData = [
            'start_time' => $newStartTime,
            'end_time' => $newEndTime,
        ];

        $response = $this->patch("/api/courses/{$course->id}", $newData);

        $response->assertStatus(200)
            ->assertJsonFragment($newData);
    }

    public function test_delete_course()
    {
        $course = Course::factory()->create();

        $response = $this->delete("/api/courses/{$course->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
    }
}
