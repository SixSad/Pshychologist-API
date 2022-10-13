<?php

namespace App\Rules;

use App\Helpers\DateHelper;
use App\Helpers\SessionHelper;
use App\Models\Consultation;
use Carbon\Carbon;
use Egal\Validation\Rules\Rule as EgalRule;
use Sixsad\Helpers\SessionAttributes;

class UniqueConsultationRule extends EgalRule
{

    public function validate($attribute, $value, $parameters = null): bool
    {

        (!empty($parameters))
            ? $psychologist_id = Consultation::query()->findOrFail($parameters[0])->psychologist_id
            : $psychologist_id = SessionAttributes::getAttributes()['psychologist_id'];

        $date = DateHelper::convertTimezone($value, 0, SessionHelper::getTimezone());

        $consultation = Consultation::query()->where([
            'psychologist_id' => $psychologist_id,
            'date' => $date,
            'status' => 'booked'
        ])->exists();

        return !$consultation;
    }

    public function message(): string
    {
        return 'The consultation is already booked';
    }

}
