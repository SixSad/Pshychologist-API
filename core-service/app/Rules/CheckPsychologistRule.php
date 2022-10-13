<?php

namespace App\Rules;

use App\Models\User;
use Egal\Core\Session\Session;
use Egal\Validation\Rules\Rule as EgalRule;

class CheckPsychologistRule extends EgalRule
{

    public function validate($attribute, $value, $parameters = null): bool
    {
        $psychologist = User::query()->where(['role' => 'psychologist', 'id' => $value])->exists();

        return $psychologist;
    }

    public function message(): string
    {
        return 'Please type correct :attribute.';
    }

}
