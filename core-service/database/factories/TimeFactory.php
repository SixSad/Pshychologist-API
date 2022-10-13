<?php

namespace Database\Factories;

use App\Models\Schedule;
use App\Models\Time;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TimeFactory extends Factory
{

    protected $model = Time::class;

    public function definition(): array
    {
        return [
            'schedule_id' => Schedule::factory(),
            'time' => $this->faker->time('H') . ":00:00"
        ];
    }
}
