<?php

namespace Database\Factories;

use App\Models\Issue;
use Illuminate\Database\Eloquent\Factories\Factory;

use function Illuminate\Support\enum_value;

/**
 * @extends Factory<Issue>
 */
class IssueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         return [
        'title' => $this->faker->sentence(3),
        'description' => $this->faker->paragraph(),
        'status' => $this->faker->randomElement(['open', 'in_progress', 'closed']),
        'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
        'due_date' => $this->faker->optional()->date(),
    ];
    }
}
