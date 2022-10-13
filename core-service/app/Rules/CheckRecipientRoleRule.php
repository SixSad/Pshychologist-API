<?php

namespace App\Rules;

use App\Models\Chat;
use Egal\Validation\Rules\Rule as EgalRule;

class CheckRecipientRoleRule extends EgalRule
{

    public function validate($attribute, $value, $parameters = null): bool
    {
        return in_array(Chat::find($value)->psychologist->role, $parameters);
    }

    public function message(): string
    {
        return "The psychologist has incorrect role.";
    }
}
