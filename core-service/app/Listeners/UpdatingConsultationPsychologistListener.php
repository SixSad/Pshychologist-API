<?php

namespace App\Listeners;

use App\Exceptions\NoAccessException;
use App\Exceptions\UpdateException;
use App\Helpers\ArrayHelper;
use App\Helpers\SessionHelper;
use Exception;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;
use Sixsad\Helpers\MicroserviceValidator;
use Sixsad\Helpers\SessionAttributes;

class UpdatingConsultationPsychologistListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        $model = $event->getModel();
        $id = SessionHelper::getUUID();
        $status = $model->getOriginal('status');

        if ($id !== $model->getAttribute('psychologist_id')) {
            throw new NoAccessException();
        }

        if ($status !== 'booked') {
            throw new Exception("Consultation already $status", 400);
        }

        ArrayHelper::arrayFilter($model->getDirty(), ['status']);

        MicroserviceValidator::validate(SessionAttributes::getAttributes(), [
            'status' => 'bail|string|in:canceled,perform',
        ]);
    }

}
