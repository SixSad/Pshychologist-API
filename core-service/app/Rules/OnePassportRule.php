<?php

namespace App\Rules;

use Egal\Validation\Rules\Rule as EgalRule;

class OnePassportRule extends EgalRule
{
    public function validate($attribute, $value, $parameters = null): bool
    {
        $passport = 0;
        foreach ($value as $item) {
            if ($item['type'] === 'passport') {
                $passport += 1;
            }
        }
        return $passport <= 1;
    }

    public function message(): string
    {
        return 'You cannot attach more than one passport.';
    }

}
