<?php

namespace App\Rules;

use App\Models\Question;
use Egal\Validation\Rules\Rule as EgalRule;

class WrongQuestionTypeRule extends EgalRule
{
    public function validate($attribute, $value, $parameters = null): bool
    {
        $type = Question::query()->find($value)->type;
        return $type === 'one';
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return "An answer option can only be associated with a question with type 'one'.";
    }
}
