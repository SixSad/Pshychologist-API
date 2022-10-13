<?php

namespace App\Rules;

use Egal\Validation\Rules\Rule as EgalRule;

class ConsultationChangedRule extends EgalRule
{

    public function validate($attribute, $value, $parameters = null): bool
    {
        return $value !== 'canceled' && $value !== 'perform';
    }

    public function message(): string
    {
        return "Consultation already changed.";
    }

}
