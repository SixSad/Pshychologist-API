<?php

namespace App\Rules;

use Egal\Core\Session\Session;
use Egal\Validation\Rules\Rule as EgalRule;

class ConsultationCheckClientRule extends EgalRule
{

    public function validate($attribute, $value, $parameters = null): bool
    {
        $user = Session::getUserServiceToken();
        return in_array('user', $user->getRoles()) && $user->getUid() === $value;
    }

    public function message(): string
    {
        return 'Please input correct client id';
    }

}
