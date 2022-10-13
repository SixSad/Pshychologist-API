<?php

namespace App\Rules;

use App\Models\Schedule;
use Egal\Core\Session\Session;
use Egal\Validation\Rules\Rule as EgalRule;

class CheckAuthorRule extends EgalRule
{

    public function validate($attribute, $value, $parameters = null): bool
    {
        $author = Schedule::find($value)->getAttribute("psychologist_id");

        $user = Session::getUserServiceToken()->getUid();

        return $author === $user;
    }

    public function message(): string
    {
        return 'The :attribute must have your id';
    }
}
