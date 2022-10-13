<?php

namespace App\Rules;

use App\Models\Question;
use Egal\Validation\Rules\Rule as EgalRule;

class UserResultRequired extends EgalRule
{
    public function validate($attribute, $value, $parameters = null): bool
    {
        foreach ($value as $item) {
            if (empty($item['question_id']) or empty($item['answer_option']) and $item['answer_option'] !== 0) {
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
        return "The question_id and answer_option fields are required.";
    }
}
