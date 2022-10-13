<?php

namespace App\Rules;

use Egal\Validation\Rules\Rule as EgalRule;

class CyrillicRule extends EgalRule
{
    public function validate($attribute, $value, $parameters = null): bool
    {

        return preg_match('/^[-А-ЯЁа-яё\s]+$/iu',$value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The :attribute must contain only the characters а-я, space or -.';
    }
}
