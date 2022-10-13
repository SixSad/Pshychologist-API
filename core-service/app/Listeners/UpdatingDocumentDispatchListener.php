<?php

namespace App\Listeners;

use App\Helpers\SessionHelper;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class UpdatingDocumentDispatchListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        if (SessionHelper::getRole() === 'admin') {
            (new UpdatingDocumentAdminListener())->handle($event);
        }
        if (SessionHelper::getRole() === 'psychologist' || SessionHelper::getRole() === 'shadow_psychologist') {
            (new UpdatingDocumentPsychologistListener())->handle($event);
        }
    }

}
