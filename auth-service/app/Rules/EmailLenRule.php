<?php

namespace App\Rules;

use Egal\Validation\Rules\Rule as EgalRule;

class EmailLenRule extends EgalRule
{
    public function validate($attribute, $value, $parameters = null): bool
    {
        $beforeAtSign = explode("@", $value)[0];

        $len = strlen($beforeAtSign);

        return $len >= $parameters[0] && $len <= $parameters[1];
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The :attribute must be more than 6 and less than 64.';
    }
}
