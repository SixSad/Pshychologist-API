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
            'id' => $this->faker->uuid,
            'first_name' => $this->faker->firstName(array_random(["male", "female"])),
            'last_name' => $this->faker->lastName,
            'patronymic' => $this->faker->firstName,
            'email' => $this->faker->email,
            'role' => 'user',
            'birthdate' => $this->faker->date,
            'sex' => $this->faker->randomElement(['male', 'female', 'none']),
            'phone_number' => "+" . "7" . $this->faker->numerify('##########')
        ];
    }
}
