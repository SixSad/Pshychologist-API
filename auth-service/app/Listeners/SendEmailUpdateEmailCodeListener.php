<?php

namespace App\Listeners;

use App\Events\SendEmailEvent;
use App\Models\EmailCode;

class SendEmailUpdateEmailCodeListener
{

    public function handle(SendEmailEvent $event): void
    {
        $ec = EmailCode::where([
            "user_id" => $event->getAttribute('id'),
            "type" => $event->type,
        ])->first();

        if (!$ec) {
            EmailCode::create([
                "user_id" => $event->getAttribute('id'),
                "type" => $event->type,
                "code" => $event->code
            ]);
        } else {
            $ec->update([
                "code" => $event->code
            ]);
        }
    }
}
