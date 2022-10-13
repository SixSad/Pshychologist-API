<?php

namespace App\Rules;

use App\Models\Consultation;
use Egal\Core\Session\Session;
use Egal\Validation\Rules\Rule as EgalRule;

class BlobUrlRule extends EgalRule
{

    public function validate($attribute, $value, $parameters = null): bool
    {
        return preg_match('/^(?:[A-Za-z\d+\/]{4})*(?:[A-Za-z\d+\/]{3}=|[A-Za-z\d+\/]{2}==)?$/',$value);
    }

    public function message(): string
    {
        return ':attribute does not match the base64 string';
    }

}
