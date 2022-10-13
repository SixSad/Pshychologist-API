<?php

namespace App\Rules;

use App\Models\Consultation;
use Egal\Core\Session\Session;
use Egal\Validation\Rules\Rule as EgalRule;

class NotCanceledRule extends EgalRule
{

    public function validate($attribute, $value, $parameters = null): bool
    {
        return $value !== 'canceled';
    }

    public function message(): string
    {
        return 'Canceled consultation cannot be rescheduled.';
    }

}
