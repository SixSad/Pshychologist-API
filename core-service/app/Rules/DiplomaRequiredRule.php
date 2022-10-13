<?php

namespace App\Rules;

use Egal\Validation\Rules\Rule as EgalRule;

class DiplomaRequiredRule extends EgalRule
{
    public function validate($attribute, $value, $parameters = null): bool
    {
        foreach ($value as $item) {
            if ($item['type'] === 'diploma') {
                return true;
            }
        }
        return false;
    }

    public function message(): string
    {
        return 'You must attach at least one diploma.';
    }

}
