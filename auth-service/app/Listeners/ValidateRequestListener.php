<?php

namespace App\Listeners;

use App\Events\SavingUserEvent;
use Sixsad\Helpers\MicroserviceValidator;

class ValidateRequestListener
{

    public function handle(SavingUserEvent $event): void
    {
        $items = $event->getAttributes();

        MicroserviceValidator::validate($items, [
            "email" => "bail|required|string|email|unique:users|lower_case|max:76|email_regex|email_len:6,46",
            "role" => "required|enum:shadow_user,shadow_psychologist"
        ]);
    }
}
