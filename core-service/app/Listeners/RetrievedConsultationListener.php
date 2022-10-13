<?php

namespace App\Listeners;

use App\Helpers\DateHelper;
use App\Helpers\SessionHelper;
use Egal\Core\Session\Session;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class RetrievedConsultationListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        $model = $event->getModel();

        if (Session::getActionMessage()->getActionName() === 'getItems') {
            $model->setAttribute(
                'date',
                DateHelper::convertTimezone(
                    $model->getAttribute('date'),
                    SessionHelper::getTimezone(),
                    flag: true
                )
            );
        }

    }

}
