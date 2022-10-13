<?php

namespace App\Listeners;

use App\Helpers\SessionHelper;
use Egal\Core\Session\Session;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class ValidatingDocumentListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        $model = $event->getModel();

        if (in_array(Session::getActionMessage()->getActionName(), ['createMany', 'create'])) {
            $model->setAttribute('psychologist_data_id', SessionHelper::getUUID());
        }

    }

}
