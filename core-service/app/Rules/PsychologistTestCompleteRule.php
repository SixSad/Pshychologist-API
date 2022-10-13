<?php

namespace App\Rules;


use App\Models\Category;
use App\Models\Question;
use Egal\Core\Session\Session;
use Egal\Validation\Rules\Rule as EgalRule;

class PsychologistTestCompleteRule extends EgalRule
{
    public function validate($attribute, $value, $parameters = null): bool
    {
        if (Session::getUserServiceToken()->getRoles()[0] !== "psychologist") {
            return true;
        }

        $questions = Question::query()->where('id', '>', 0)->pluck('id')->toArray();

        foreach ($value as $item) {
            if (in_array($item['question_id'], $questions)) {
                unset($questions[array_search($item['question_id'], $questions)]);
            }
        }

        if (!empty($questions)) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return "You must answer all questions.";
    }
}
