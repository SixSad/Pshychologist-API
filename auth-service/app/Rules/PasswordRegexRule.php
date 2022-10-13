<?php

namespace App\Rules;

use Egal\Validation\Rules\Rule as EgalRule;

class PasswordRegexRule extends EgalRule
{
    public function validate($attribute, $value, $parameters = null): bool
    {
        return !preg_match("/[^\w!@#$%^&*()_+!”№;%:?*-=]/i", $value) && preg_match("/([a-z]+(.+[0-9]|[0-9])|[0-9]+(.+[a-z]|[a-z]))/i", $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The :attribute must contain eng charters + numbers.';
    }
}
