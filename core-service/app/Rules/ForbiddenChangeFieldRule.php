<?php

namespace App\Rules;

use App\Models\Question;
use Egal\Validation\Rules\Rule as EgalRule;

class ForbiddenChangeFieldRule extends EgalRule
{

    public function validate($attribute, $value, $parameters = null): bool
    {
        return false;
    }

    public function message(): string
    {
        return 'You cannot edit the :attribute field.';
    }

}
