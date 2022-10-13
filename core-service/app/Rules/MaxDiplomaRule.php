<?php

namespace App\Rules;

use Egal\Validation\Rules\Rule as EgalRule;

class MaxDiplomaRule extends EgalRule
{
    public function validate($attribute, $value, $parameters = null): bool
    {
        $diploma = 0;
        foreach ($value as $item) {
            if ($item['type'] === 'diploma') {
                $diploma += 1;
            }
        }
        return $diploma <= 3;
    }

    public function message(): string
    {
        return 'You cannot attach more than three diplomas.';
    }

}
