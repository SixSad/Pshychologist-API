<?php

namespace App\Rules;

use Egal\Validation\Rules\Rule as EgalRule;

class PhoneNumberRule extends EgalRule
{
    public function validate($attribute, $value, $parameters = null): bool
    {
        return  strlen($value) === 12 && preg_match('/[+]{1}?[7]{1}?[0-9]{10}$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return "The field :attribute must contain only '+7' and 10 digits.";
    }
}
