<?php

namespace App\Rules;

use App\Helpers\SessionHelper;
use Carbon\Carbon;
use Egal\Validation\Rules\Rule as EgalRule;

class CheckTimeRule extends EgalRule
{
    public function validate($attribute, $value, $parameters = null): bool
    {
        return Carbon::parse($value) <= Carbon::today(SessionHelper::getTimezone())->addDays(7) && Carbon::parse($value) > Carbon::now(SessionHelper::getTimezone());
    }

    public function message(): string
    {
        return 'The :attribute must be between (now - now+7days).';
    }
}
