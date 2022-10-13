<?php

namespace App\Listeners;

use App\Helpers\ArrayHelper;
use App\Helpers\SessionHelper;
use Egal\Core\Exceptions\NoAccessActionCallException;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class UpdatingScheduleValidateListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        $model = $event->getModel();

        if($model->getAttribute('psychologist_id') !== SessionHelper::getUUID()){
            throw new NoAccessActionCallException();
        }

        ArrayHelper::arrayFilter($model->getDirty(), ['expiration_date']);
    }

}
