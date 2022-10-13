<?php

namespace Database\Factories;

use App\Models\PsychologistData;
use App\Models\User;
use App\Models\UserResult;
use App\Models\WorkCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserResultFactory extends Factory
{

    protected $model = UserResult::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()
        ];
    }

}
