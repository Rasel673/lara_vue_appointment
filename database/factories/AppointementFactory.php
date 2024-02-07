<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
use App\Models\Client;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointement>
 */
class AppointementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => Client::factory()->create()->id,
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'start_date' =>$starTime=fake()->dateTimeBetween('-1 year','+1 year'),
            'start_date' =>Carbon::parse($starTime)->addHours(2),
            'status' => rand(1,3),

        ];
    }
}
