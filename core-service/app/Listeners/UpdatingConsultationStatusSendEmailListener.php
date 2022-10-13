<?php

namespace App\Listeners;

use App\Helpers\SessionHelper;
use App\Jobs\ConsultationPsychologistCanceledSender;
use App\Jobs\ConsultationUserCanceledSender;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class UpdatingConsultationStatusSendEmailListener extends AbstractListener
{
    public function handle(AbstractEvent $event): void
    {
        if ($event->getAttribute('status') === 'canceled') {
            SessionHelper::getRole() === 'user'
                ? dispatch(new ConsultationUserCanceledSender($event->getModel()))
                : dispatch(new ConsultationPsychologistCanceledSender($event->getModel()));
        }
    }
}
