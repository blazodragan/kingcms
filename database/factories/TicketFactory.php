<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $month = $this->faker->numberBetween($min = 1, $max = 12);
        $month = str_pad($month, 2, '0', STR_PAD_LEFT);
        $date = "2023-$month-01"; 
        return [
            'uuid' => $this->faker->uuid(),
            'title' => $this->faker->name(),
            'message' => $this->faker->paragraph(2),
            'priority' => $this->faker->randomElement(['low', 'normal', 'high']),
            'status' => $this->faker->randomElement(['open', 'closed']),
            'is_resolved' => $this->faker->randomElement([true, false]),
            'is_locked' => $this->faker->randomElement([true, false]),
            'created_at' => $date
        ];
    }
}
