<?php

namespace Database\Factories;

use App\Enums\RideStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ride>
 */
class RideFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'from' => fake()->name(),
            'to' => fake()->unique()->safeEmail(),
            'requester_user_id' => User::first()?->id,
            'status' => RideStatus::REQUESTED,
        ];
    }
}
