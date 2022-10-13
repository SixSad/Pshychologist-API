<?php

namespace App\Rules;

use App\Models\Time;
use Egal\Validation\Rules\Rule as EgalRule;

class ScheduleTimeExistsRule extends EgalRule
{

    public function validate($attribute, $value, $parameters = null): bool
    {
        return !Time::where(["schedule_id" => $parameters[0], "time" => $value])->exists();
    }

    public function message(): string
    {
        return "Time :input already exists";
    }

}
