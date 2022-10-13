<?php

namespace App\Listeners;

use App\Exceptions\NoAccessException;
use App\Helpers\ArrayHelper;
use App\Helpers\SessionHelper;
use App\Models\Consultation;
use Exception;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;
use Sixsad\Helpers\MicroserviceValidator;
use Sixsad\Helpers\SessionAttributes;

class StatusUpdateValidateListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        $model = $event->getModel();
        $id = SessionHelper::getUUID();
        $consultationStatus = Consultation::query()->find($model->getAttribute('id'))->getAttribute('status');

        ArrayHelper::arrayFilter(SessionAttributes::getAttributes(), ['status']);

        MicroserviceValidator::validateFirstFail(SessionAttributes::getAttributes(), [
            'status' => 'required|string|in:canceled,perform'
        ]);

        if ($consultationStatus !== 'booked') {
            throw new Exception("Consultation already $consultationStatus", 400);
        }

        if ($id !== $model->client_id && $id !== $model->psychologist_id) {
            throw new NoAccessException();
        }

        if (SessionAttributes::getAttributes()['status'] === 'perform' && SessionHelper::getRole() !== 'psychologist') {
            throw new NoAccessException();
        }
    }

}
