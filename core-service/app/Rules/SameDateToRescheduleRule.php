<?php

namespace App\Rules;

use App\Models\Consultation;
use Carbon\Carbon;
use Egal\Validation\Rules\Rule as EgalRule;

class SameDateToRescheduleRule extends EgalRule
{
    public function validate($attribute, $value, $parameters = null): bool
    {
        if (empty($parameters)) {
            return false;
        }
        $consultation = Consultation::query()->findOrFail($parameters[0]);
        return Carbon::parse($value) != Carbon::parse($consultation->date);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return "You cannot reschedule the session to the same date.";
    }
}
