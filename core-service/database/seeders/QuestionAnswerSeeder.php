<?php

namespace Database\Seeders;

use App\Helpers\Consts;
use App\Models\AnswerOption;
use App\Models\Category;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\User;
use App\Models\UserResult;
use Illuminate\Database\Seeder;

class QuestionAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        QuestionAnswer::unsetEventDispatcher();
        $questions = Question::all();
        $userResults = UserResult::all();

        foreach ($questions as $question) {
            foreach ($userResults as $result) {
                if (QuestionAnswer::query()->where([
                    'user_result_id' => $result->getAttribute('id'),
                    "question_id" => $question->getAttribute('id'),
                ])->exists()) {
                    continue;
                }
                if ($question->getAttribute('type') === Consts::QUESTION_TYPE_MANY) {
                    QuestionAnswer::actionSeederCreate([
                        "user_result_id" => $result->getAttribute('id'),
                        "question_id" => $question->getAttribute('id'),
                        "answer_option" => random_int(0, 4)
                    ]);
                } else {
                    $answer = AnswerOption::inRandomOrder()->where('question_id', $question->getAttribute('id'))->first();
                    QuestionAnswer::actionSeederCreate([
                        "user_result_id" => $result->getAttribute('id'),
                        "question_id" => $question->getAttribute('id'),
                        "answer_option" => $answer->getAttribute('id')
                    ]);
                }
            }
        }
    }
}
