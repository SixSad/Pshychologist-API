<?php

namespace App\Listeners;

use App\Events\SavedUserEvent;
use App\Models\EmailCode;

class CreateEmailCodeListener
{
    public function handle(SavedUserEvent $event): void
    {
        EmailCode::actionCreate([
            "user_id" =>  $event->getAttribute('id'),
            "code" => $event->code,
            "type" => $event->type,
        ]);
    }
}
