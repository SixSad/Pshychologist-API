<?php

namespace App\Rules;

use App\Helpers\SessionHelper;
use Egal\Validation\Rules\Rule as EgalRule;

class CheckUserAuthorRule extends EgalRule
{

    public function validate($attribute, $value, $parameters = null): bool
    {
        return $value === SessionHelper::getUUID();
    }

    public function message(): string
    {
        return "The :attribute has not your id";
    }
}
