<?php

namespace App\Listeners;

use App\Helpers\SessionHelper;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class UpdatingPsychologistDataDispatchListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        if (SessionHelper::getRole() === 'psychologist' || SessionHelper::getRole() === 'shadow_psychologist') {
            (new UpdatingPsychologistDataPsychologistListener())->handle($event);
        }
    }

}
