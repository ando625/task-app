<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\Task;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'content' => fake()->paragraph(),
            'priority' => fake()->randomElement([1,2,3]),
            'due_at' => fake()->dateTime(),
            'status' => fake()->randomElement(['todo', 'in_progress', 'completed']),
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
        ];
    }
}
