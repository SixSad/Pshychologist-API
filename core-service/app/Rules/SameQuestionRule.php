<?php

namespace App\Rules;

use Egal\Validation\Rules\Rule as EgalRule;

class SameQuestionRule extends EgalRule
{
    public function validate($attribute, $value, $parameters = null): bool
    {
        $questions = [];
        foreach ($value as $item) {
            if (in_array($item['question_id'], $questions)) {
                return false;
            }
            $questions[] = $item['question_id'];
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
        return "You cannot submit the same question multiple times.";
    }
}
