<?php

namespace App\Rules;

use Egal\Validation\Rules\Rule as EgalRule;

class DocumentsDescriptionRule extends EgalRule
{
    public function validate($attribute, $value, $parameters = null): bool
    {
        foreach ($value as $item) {
            if (($item['type'] === 'passport' or $item['type'] === 'other') and !empty($item['description'])) {
                return false;
            }
        }
        return true;
    }

    public function message(): string
    {
        return 'The field description must be only for diplomas.';
    }

}
