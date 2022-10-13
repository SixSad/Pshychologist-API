<?php

namespace App\Rules;

use App\Models\User;
use Egal\Validation\Rules\Rule as EgalRule;

class CheckUserRoleRule extends EgalRule
{

    public function validate($attribute, $value, $parameters = null): bool
    {
        return in_array(User::where("id", $value)->first()->role, $parameters);
    }

    public function message(): string
    {
        return "The :attribute has incorrect role.";
    }
}
