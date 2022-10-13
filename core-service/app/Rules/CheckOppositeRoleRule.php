<?php

namespace App\Rules;

use App\Models\User;
use Egal\Core\Session\Session;
use Egal\Validation\Rules\Rule as EgalRule;

class CheckOppositeRoleRule extends EgalRule
{

    public function validate($attribute, $value, $parameters = null): bool
    {
        return !in_array(User::where("id", $value)->first()->role, Session::getUserServiceToken()->getRoles());
    }

    public function message(): string
    {
        return "The :attribute has the same role as you";
    }
}
