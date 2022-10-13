<?php

namespace App\Rules;

use App\Models\Question;
use Egal\Validation\Rules\Rule as EgalRule;

class WrongQuestionRule extends EgalRule
{
    public function validate($attribute, $value, $parameters = null): bool
    {
        foreach ($value as $item) {
            if (empty(Question::query()->find($item['question_id']))) {
                return false;
            }
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
        return "There is no question with this id.";
    }
}
