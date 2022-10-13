<?php

namespace App\Listeners;

use App\Exceptions\NoAccessException;
use App\Helpers\ArrayHelper;
use App\Helpers\SessionHelper;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;
use Sixsad\Helpers\MicroserviceValidator;

class UpdatingDocumentPsychologistListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        $model = $event->getModel();
        if ($model->getAttribute('psychologist_data_id') !== SessionHelper::getUUID()) {
            throw new NoAccessException();
        }

        MicroserviceValidator::validate($model->getDirty(), [
            'photo' => 'filled|string',
            'description' => 'filled|string|max:2000|min:3'
        ]);

        ArrayHelper::arrayFilter($model->getDirty(), ['photo', 'description']);

        $model->setAttribute('verified', null);
    }

}
