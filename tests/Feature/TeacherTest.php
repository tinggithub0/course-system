<?php

namespace Tests\Feature;

use Faker\Factory;
use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeacherTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_teachers()
    {
        $response = $this->get('/api/teachers');
    
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                    ]
                ],
                'meta' => [
                    'page',
                    'per_page',
                    'next_page',
                ]
            ]);
    }

    public function test_create_new_teacher()
    {
        $faker = Factory::create();
        $userData = [
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'password' => bcrypt('password123'),
            'role' => 2,
        ];

        $response = $this->post('/api/teachers', $userData);

        $response->assertStatus(201);

        $teacherId = $response->json('id');
        $teacher = User::find($teacherId);
    
        $this->assertNotNull($teacher, 'Teacher 未正確建立');

        $this->assertEquals($userData['name'], $teacher->name);
        $this->assertEquals($userData['email'], $teacher->email);
    }

    public function test_get_teacher_courses()
    {
        $perPage = 5;
        $teacher = User::factory()->create();
        $courses = Course::factory()->count($perPage)->create(['teacher_id' => $teacher->id]);

        $response = $this->get("/api/teachers/{$teacher->id}/courses?per_page={$perPage}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'introduction',
                        'start_time',
                        'end_time'
                    ]
                ],
                'meta' => [
                    'page',
                    'per_page',
                    'next_page',
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
        }
    }
}
