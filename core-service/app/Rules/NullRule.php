<?php

namespace App\Rules;


use App\Models\Category;
use App\Models\Question;
use Egal\Core\Session\Session;
use Egal\Validation\Rules\Rule as EgalRule;

class NullRule extends EgalRule
{
    public function validate($attribute, $value, $parameters = null): bool
    {
        return is_null($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return "The :attribute must be a null.";
    }
}
