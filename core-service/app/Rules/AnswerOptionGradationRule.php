<?php

namespace App\Rules;

use App\Models\Question;
use Egal\Validation\Rules\Rule as EgalRule;

class AnswerOptionGradationRule extends EgalRule
{

    public function validate($attribute, $value, $parameters = null): bool
    {
        foreach ($value as $item) {
            $question = Question::query()->findOrFail($item['question_id']);

            if (($question->getAttribute('type') === 'many') and ($item['answer_option'] < 0 or $item['answer_option'] > 4)) {
                return false;
            }
        }
        return true;
    }

    public function message(): string
    {
        return 'The answer does not correspond to the gradation';
    }

}
