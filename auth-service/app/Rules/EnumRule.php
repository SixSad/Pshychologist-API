<?php

namespace App\Rules;

use Egal\Validation\Rules\Rule as EgalRule;

class EnumRule extends EgalRule
{
    public function validate($attribute, $value, $parameters = null): bool
    {
        return in_array($value, $parameters);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The :attribute must be one of the busy parameters .';
    }
}
