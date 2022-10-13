<?php

namespace App\Rules;

use App\Helpers\DateHelper;
use App\Helpers\SessionHelper;
use App\Models\Consultation;
use App\Models\Schedule;
use Carbon\Carbon;
use Egal\Model\Builder;
use Egal\Validation\Rules\Rule as EgalRule;
use Sixsad\Helpers\SessionAttributes;

class CheckScheduleRule extends EgalRule
{

    public function validate($attribute, $value, $parameters = null): bool
    {
        (!empty($parameters))
            ? $psychologist_id = Consultation::query()->findOrFail($parameters[0])->psychologist_id
            : $psychologist_id = SessionAttributes::getAttributes()['psychologist_id'];

        $day = DateHelper::convertTimezone($value, 0, SessionHelper::getTimezone(), true, 'd');
        $hour = DateHelper::convertTimezone($value, 0, SessionHelper::getTimezone(), true, 'HH:mm:ss');

        $schedules = Schedule::query()->where([
            ['psychologist_id', '=', $psychologist_id],
            ['week_day', '=', $day]
        ])->whereHas('times', function (Builder $query) use ($hour) {
            $query->where('time', '=', $hour);
        })->exists();

        return $schedules;
    }

    public function message(): string
    {
        return 'The :attribute must be valid (:attribute in psychologist schedule).';
    }

}
