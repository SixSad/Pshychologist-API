<?php

namespace App\Rules;

use App\Helpers\DateHelper;
use App\Helpers\SessionHelper;
use Egal\Validation\Rules\Rule as EgalRule;
use Illuminate\Support\Carbon;

class CheckTimeBeforeRule extends EgalRule
{
    public function validate($attribute, $value, $parameters = null): bool
    {
        return DateHelper::convertTimezone($value, currentTz: SessionHelper::getTimezone()) >= Carbon::now(SessionHelper::getTimezone())->addHours($parameters[0]);
    }

    public function message(): string
    {
        return "Wrong date";
    }

}
