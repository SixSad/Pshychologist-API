<?php

namespace App\Rules;

use Egal\Validation\Rules\Rule as EgalRule;

class DiplomaDescriptionRule extends EgalRule
{
    public function validate($attribute, $value, $parameters = null): bool
    {
        foreach ($value as $item) {
            if ($item['type'] === 'diploma' and empty($item['description'])) {
                return false;
            }
        }
        return true;
    }

    public function message(): string
    {
        return 'Diploma description required.';
    }

}
