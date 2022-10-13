<?php

namespace App\Rules;

use App\Helpers\Consts;
use App\Models\Question;
use Egal\Validation\Rules\Rule as EgalRule;

class AnswerOptionOneRule extends EgalRule
{
    public function validate($attribute, $value, $parameters = null): bool
    {
        foreach ($value as $item) {

            $question = Question::query()->findOrFail($item['question_id']);
            $existAnswer = $question->answerOptions->where("id", $item['answer_option']);

            if (($question->getAttribute('type') === Consts::QUESTION_TYPE_ONE) and empty(count($existAnswer))) {
                return false;
            }
        }
        return true;
    }

    public function message(): string
    {
        return 'The answer does not match this question.';
    }

}
