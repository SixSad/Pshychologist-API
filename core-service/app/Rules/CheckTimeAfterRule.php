<?php

namespace App\Rules;

use Egal\Validation\Rules\Rule as EgalRule;

class CheckTimeAfterRule extends EgalRule
{

    public function validate($attribute, $value, $parameters = null): bool
    {
        $splited_time = explode(":", $value);
        return $splited_time[1] == '00' && $splited_time[2] == '00';
    }

    public function message(): string
    {
        return 'The :attribute must be format H:00:00';
    }
}
