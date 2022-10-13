<?php

namespace Database\Factories;

use App\Models\QuestionAnswer;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionAnswerFactory extends Factory
{

    protected $model = QuestionAnswer::class;

    public function definition(): array
    {
        return [
            "answer_option" => $this->faker->numberBetween(0, 4),
        ];
    }
}
