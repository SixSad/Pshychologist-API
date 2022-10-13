<?php

namespace App\Listeners;

use App\Helpers\DateHelper;
use App\Helpers\SessionHelper;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class CreatingConsultationValidateConsultationListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        parent::handle($event);
        $model = $event->getModel();

        $model->setAttribute(
            'date',
            DateHelper::convertTimezone($event->getAttribute('date'), 0, SessionHelper::getTimezone())
        );

    }

}
