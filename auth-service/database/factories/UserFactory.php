<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{

    protected $model = User::class;

    public function definition(): array
    {
        return [
            "id" => $this->faker->uuid(),
            'email' => $this->faker->email,
            'password' => $this->faker->password,
        ];
    }
}