<?php

namespace Database\Factories;

use App\Models\AnswerOption;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnswerOptionFactory extends Factory
{

    protected $model = AnswerOption::class;

    public function definition(): array
    {
        return [
            'client_title' => $this->faker->unique()->sentence,
            'psychologist_title' => $this->faker->unique()->sentence,
            'question_id' => Question::factory()
        ];
    }

}
