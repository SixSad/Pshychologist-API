<?php

namespace App\Rules;

use App\Models\Question;
use Egal\Validation\Rules\Rule as EgalRule;

class UserResultInteger extends EgalRule
{
    public function validate($attribute, $value, $parameters = null): bool
    {
        foreach ($value as $item) {
            if (!is_integer($item['question_id']) or !is_integer($item['answer_option'])) {
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
        return "The question_id and answer_option fields must be an integer.";
    }
}
