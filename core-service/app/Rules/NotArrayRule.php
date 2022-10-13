<?php

namespace App\Rules;

use App\Models\Schedule;
use Carbon\Carbon;
use Egal\Validation\Rules\Rule as EgalRule;
use Sixsad\Helpers\SessionAttributes;

class NotArrayRule extends EgalRule
{

    public function validate($attribute, $value, $parameters = null): bool
    {
        return !is_array($value);
    }

    public function message(): string
    {
        return "The :attribute mustn't be array or object.";
    }

}
