<?php

namespace App\Rules;

use Egal\Validation\Rules\Rule as EgalRule;

class PassportRequiredRule extends EgalRule
{
    public function validate($attribute, $value, $parameters = null): bool
    {
        foreach ($value as $item) {
            if ($item['type'] === 'passport') {
                return true;
            }
        }
        return false;
    }

    public function message(): string
    {
        return 'You must attach your passport.';
    }

}
