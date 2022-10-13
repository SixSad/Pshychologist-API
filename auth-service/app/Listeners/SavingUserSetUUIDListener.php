<?php

namespace App\Listeners;

use App\Events\SavingUserEvent;
use Illuminate\Support\Str;

class SavingUserSetUUIDListener
{

    public function handle(SavingUserEvent $event): void
    {
        $event->setModelAttribute("id", Str::uuid());
    }
}
