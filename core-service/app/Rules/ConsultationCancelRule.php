<?php

namespace App\Rules;

use App\Models\Consultation;
use Egal\Core\Session\Session;
use Egal\Validation\Rules\Rule as EgalRule;

class ConsultationCancelRule extends EgalRule
{

    public function validate($attribute, $value, $parameters = null): bool
    {
        if (empty($parameters)) {
            return false;
        }

        $user_id = Session::getUserServiceToken()->getUid();
        $consultation = Consultation::query()->findOrFail((int)$parameters[0]);
        return $user_id === $consultation->psychologist_id or $user_id === $consultation->client_id;
    }

    public function message(): string
    {
        return 'You cannot unsubscribe.';
    }

}
