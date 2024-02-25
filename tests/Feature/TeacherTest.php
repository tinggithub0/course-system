<?php

namespace Tests\Feature;

use Faker\Factory;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeacherTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_teachers()
    {
        $response = $this->createUserWithTokenRequest()
            ->get('/api/teachers');
    
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
        ];

        $response = $this->createUserWithTokenRequest(User::ROLE_ADMIN)
            ->post('/api/teachers', $userData);

        $response->assertStatus(201);

        $teacherId = $response->json('id');
        $teacher = User::find($teacherId);
    
        $this->assertNotNull($teacher, 'Teacher 未正確建立');

        $this->assertEquals($userData['name'], $teacher->name);
        $this->assertEquals($userData['email'], $teacher->email);
    }
}
