<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'teacher_id' => \App\Models\User::factory()
                ->create(['role' => User::ROLE_TEACHER])
                ->id,
            'name' => $this->faker->name,
            'introduction' => $this->faker->text,
            'start_time' => $this->faker->dateTimeBetween('-1 hours', 'now')->format('Hi'),
            'end_time' => $this->faker->dateTimeBetween('now', '+1 hours')->format('Hi'),
        ];
    }
}
