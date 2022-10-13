<?php

namespace App\Listeners;

use App\Events\DeletingEmailCodeEvent;
use App\Services\EmailCodeService;
use Error;

class DeletingEmailcheckCodeListener
{
    public function handle(DeletingEmailCodeEvent $event): void
    {
        $ecs = new EmailCodeService($event->getModel());

        if ($ecs->CheckTimeout()) {
            throw new Error("Сode ended", 405);
        }
    }
}
