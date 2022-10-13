<?php

namespace App\Rules;

use App\Helpers\SessionHelper;
use Egal\Core\Session\Session;
use Egal\Validation\Rules\Rule as EgalRule;

class UpdateQuestionTypeRule extends EgalRule
{

    public function validate($attribute, $value, $parameters = null): bool
    {
        return Session::getActionMessage()->getActionName() === "update" && in_array("type", Session::getActionMessage()->getParameters());
    }

    public function message(): string
    {
        return "You cannot update :attribute field";
    }

}
