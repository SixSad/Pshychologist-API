<?php

namespace App\Rules;

use App\Models\Question;
use Egal\Validation\Rules\Rule as EgalRule;
use Illuminate\Validation\Concerns\ReplacesAttributes;
use Sixsad\Helpers\SessionAttributes;

class ProhibitedAttributeRule extends EgalRule
{
    use ReplacesAttributes;

    public function passes($attribute, $value)
    {
        return parent::passes($attribute, $value);
    }

    public function validate($attribute, $value, $parameters = null): bool
    {
        return SessionAttributes::getAttributes()[$parameters[0]] !== $parameters[1];
    }

    public function message(): string
    {
        return 'The :attribute is prohibited when :other';
    }

}
