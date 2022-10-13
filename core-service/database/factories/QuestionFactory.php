<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{

    protected $model = Question::class;

    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'client_title' => $this->faker->unique()->sentence,
            'psychologist_title' => $this->faker->unique()->sentence,
            'type' => $this->faker->randomElement(['one', 'many']),
            'psychologist_reverse' => $this->faker->boolean,
            'client_reverse' => $this->faker->boolean,
        ];
    }
}
