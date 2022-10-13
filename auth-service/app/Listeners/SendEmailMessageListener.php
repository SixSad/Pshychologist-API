<?php

namespace App\Listeners;

use App\Events\SavedUserEvent;
use App\Helpers\CreateMail;

class SendEmailMessageListener
{

    public function handle(SavedUserEvent $event): void
    {
        $code = $event->code;

        $type = $event->type;

        $email = $event->getAttribute("email");

        $cm = new CreateMail($email, $code, $type);

        $mail = $cm->generate();

        $mail->send();
    }
}
