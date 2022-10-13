<?php

namespace Database\Factories;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{

    protected $model = Schedule::class;

    public function definition(): array
    {
        return [
            'expiration_date' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            'psychologist_id' => User::factory(),
            'week_day' => $this->faker->randomElement(['0', '1', '2', '3', '4', '5', '6'])
        ];
    }
}
