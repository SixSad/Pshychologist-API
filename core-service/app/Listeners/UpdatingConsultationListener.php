<?php

namespace App\Listeners;

use App\Helpers\SessionHelper;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class UpdatingConsultationListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        if (SessionHelper::getRole() === 'user') {
            (new UpdatingConsultationUserListener())->handle($event);
        }

        if (SessionHelper::getRole() === 'psychologist') {
            (new UpdatingConsultationPsychologistListener())->handle($event);
        }
    }

}
