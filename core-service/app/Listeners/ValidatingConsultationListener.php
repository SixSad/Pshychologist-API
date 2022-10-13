<?php

namespace App\Listeners;

use App\Helpers\Consts;
use App\Helpers\SessionHelper;
use Egal\Core\Session\Session;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class ValidatingConsultationListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        $model = $event->getModel();

        if(Session::getActionMessage()->getActionName() === 'create'){
            $model->setAttribute('status', Consts::STATUS_BOOKED);
            $model->setAttribute('client_id', SessionHelper::getUUID());
        }

    }

}
