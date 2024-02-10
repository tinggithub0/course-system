<?php

namespace Database\Factories;

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
            'teacher_id' => \App\Models\User::factory()->create()->id,
            'name' => $this->faker->name,
            'introduction' => $this->faker->text,
            'start_time' => $this->faker->time('Hi'),
            'end_time' => $this->faker->time('Hi'),
        ];
    }
}
