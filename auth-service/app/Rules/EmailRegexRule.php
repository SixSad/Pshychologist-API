<?php

namespace App\Rules;

use Egal\Validation\Rules\Rule as EgalRule;

class EmailRegexRule extends EgalRule
{

    public function validate($attribute, $value, $parameters = null): bool
    {
        return !preg_match("/[^\w.@-]/i", $value);
    }

    public function message(): string
    {
        return "The :attribute field invalid";
    }
}
