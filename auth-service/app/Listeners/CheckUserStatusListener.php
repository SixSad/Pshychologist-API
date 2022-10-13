<?php

namespace App\Listeners;

use App\Events\SavedUserEvent;
use App\Helpers\Consts;
use Error;

class CheckUserStatusListener
{

    public function handle(SavedUserEvent $event): void
    {
        $userStatus = $event->getAttribute("status");

        $status = Consts::STATUSES[$event->type];

        if ($userStatus !== $status) {
            throw new Error("User status must be $status", 405);
        }
    }
}
