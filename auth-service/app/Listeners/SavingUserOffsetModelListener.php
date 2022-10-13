<?php

namespace App\Listeners;

use App\Events\SavingUserEvent;

class SavingUserOffsetModelListener
{

    public function handle(SavingUserEvent $event): void
    {
        $event->clearModelAttribute("role");
    }
}
