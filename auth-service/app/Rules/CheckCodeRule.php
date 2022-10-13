<?php

namespace App\Rules;

use App\Models\EmailCode;
use Egal\Validation\Rules\Rule as EgalRule;

class CheckCodeRule extends EgalRule
{

    public function validate($attribute, $value, $parameters = null): bool
    {
        return (bool)EmailCode::where([
            "code" => $value,
            "type" => $parameters[0]
        ])->first();
    }

    public function message(): string
    {
        return "Code not found";
    }
}
