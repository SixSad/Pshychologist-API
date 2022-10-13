<?php

namespace App\Rules;

use Egal\Validation\Rules\Rule as EgalRule;
use Sixsad\Helpers\SessionAttributes;

class TypeReverseRule extends EgalRule
{
    public function validate($attribute, $value, $parameters = null): bool
    {
        $attributes = SessionAttributes::getAttributes();

        if ($attributes['type'] !== 'many') {
            return true;
        }

        if (!array_key_exists('client_reverse', $attributes) or !array_key_exists('psychologist_reverse', $attributes)) {
            return false;
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
        return "If the question type is many, the reverse fields are required.";
    }
}
